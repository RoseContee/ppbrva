<?php

namespace App\Http\Controllers;

use App\Mail\MemberMail;
use App\Models\Email;
use App\Models\EmailAttachment;
use App\Models\Member;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    public function __construct(Request $request) {
        if ($request->method() == 'GET'
            && $request->route()->getName() != 'emails.read'
        ) {
            $members = Member::query()
                ->oldest('firstname')
                ->get(['id', 'firstname', 'lastname', 'email']);
            view()->share('members', $members);
        }
    }

    public function sent() {
        $emails = Email::query()
            ->with([
                'attachments' => function (HasMany $query) {
                    $query->whereNull('embedded')
                        ->select(['email_id']);
                }
            ])
            ->whereNotNull('sent_at')
            ->latest('sent_at')
            ->select(['id', 'to', 'subject', 'sent_at', 'updated_at'])
            ->get();
        return view('emails', [
            'type' => 'sent',
            'emails' => $emails,
        ]);
    }

    public function draft() {
        $emails = Email::query()
            ->with([
                'attachments' => function (HasMany $query) {
                    $query->whereNull('embedded')
                        ->select(['email_id']);
                }
            ])
            ->whereNull('sent_at')
            ->latest('updated_at')
            ->select(['id', 'to', 'subject', 'sent_at', 'updated_at'])
            ->get();
        return view('emails', [
            'type' => 'draft',
            'emails' => $emails,
        ]);
    }

    public function trash() {
        $emails = Email::query()
            ->with([
                'attachments' => function (HasMany $query) {
                    $query->whereNull('embedded')
                        ->select(['email_id']);
                }
            ])
            ->whereNotNull('deleted_at')
            ->withTrashed()
            ->latest('sent_at')
            ->latest('updated_at')
            ->select(['id', 'to', 'subject', 'sent_at', 'updated_at'])
            ->get();
        return view('emails', [
            'type' => 'trash',
            'emails' => $emails,
        ]);
    }

    public function read($id) {
        $email = Email::query()
            ->with([
                'attachments' => function (HasMany $query) {
                    $query->whereNull('embedded')
                        ->select(['id', 'email_id', 'filename']);
                }
            ])
            ->withTrashed()
            ->select(['id', 'to', 'cc', 'bcc', 'subject', 'content', 'sent_at', 'updated_at'])
            ->find($id);
        if (!$email) {
            return response()->json([
                'status' => 'Not found',
            ], 404);
        }
        return response()->json($email);
    }

    public function send(Request $request) {
        $email = $this->saveEmailAsDraft($request);
        if (gettype($email) == 'string') {
            return to_route('emails.draft')
                ->with('error_message', $email);
        }
        try {
            $content = $email['content'];
            $files = [];
            preg_match_all('/src="data:image\/[a-z]+;base64,[^"]*"/i', $content, $matches);
            foreach ($matches[0] as $base64Image) {
                $base64Image = rtrim(ltrim($base64Image, 'src="'), '"');
                if (empty($files[$base64Image])) {
                    $pos = strpos($base64Image, ',');
                    $info = substr($base64Image, 0, $pos);
                    $ext = explode('/', explode(';', $info)[0])[1];
                    $image = base64_decode(substr($base64Image, $pos + 1));
                    $filename = Str::random(40).".{$ext}";
                    Storage::put($path = "attachments/{$filename}", $image);
                    $path = "uploads/{$path}";
                    EmailAttachment::query()
                        ->create([
                            'email_id' => $email['id'],
                            'filename' => $filename,
                            'path' => $path,
                            'embedded' => true,
                        ]);
                    $content = str_replace($base64Image, asset($path), $content);
                    $files[$base64Image] = true;
                }
            }
            $email['content'] = $content;
            Mail::to($email['to'])
                ->cc($email['cc'])
                ->bcc($email['bcc'])
                ->send(new MemberMail($email));
            $email['sent_at'] = now();
            $email->save();
        } catch (\Exception $exception) {
            logger($exception->getMessage());
            return to_route('emails.draft')
                ->with('warning_message', 'Email has not been sent.');
        }
        return back()->with('success_message', 'Email has been sent successfully.');
    }

    public function saveDraft(Request $request) {
        $email = $this->saveEmailAsDraft($request);
        if (gettype($email) == 'string') {
            return to_route('emails.draft')
                ->with('error_message', $email);
        }
        return to_route('emails.draft')
            ->with('info_message', 'Email has been saved in draft.');
    }

    public function discard(Request $request) {
    }

    public function destroy(Request $request) {
        $request->validate([
            'type' => ['required', 'in:sent,draft,trash'],
            'emails' => ['array'],
            'emails.*' => ['numeric'],
        ]);
        $type = $request['type'];
        $query = Email::query()
            ->whereIn('id', $request['emails'] ?? []);
        if ($type == 'sent') {
            $query->whereNotNull('sent_at')
                ->delete();
        } else if ($type == 'draft') {
            $query->whereNull('sent_at')
                ->delete();
        } else {
            $emails = $query->whereNotNull('deleted_at')
                ->with('attachments')
                ->withTrashed()
                ->get();
            foreach ($emails as $email) {
                foreach ($email['attachments'] as $file) {
                    unlink(public_path($file['path']));
                    $file->delete();
                }
                $email->forceDelete();
            }
        }
        return response()->json([
            'status' => 'OK',
        ]);
    }

    public function destroyAttachment(Request $request) {
        $attachment = EmailAttachment::query()
            ->find($request['attachment']);
        unlink(public_path($attachment['path']));
        $attachment->delete();
        return response()->json([
            'status' => 'OK',
        ]);
    }

    public function restore(Request $request) {
        $request->validate([
            'emails' => ['array'],
            'emails.*' => ['numeric'],
        ]);
        Email::query()
            ->whereIn('id', $request['emails'] ?? [])
            ->whereNotNull('deleted_at')
            ->withTrashed()
            ->restore();
        return response()->json([
            'status' => 'OK',
        ]);
    }

    protected function saveEmailAsDraft(Request $request): string|Email {
        $rule = [
            'to' => ['nullable', 'array'],
            'to.*' => ['exists:members,id'],
            'cc' => ['nullable', 'email'],
            'bcc' => ['nullable', 'email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $error = '';
            foreach ($validator->errors()->getMessages() as $err) {
                $error = $err[0].'<br>';
            }
            return $error;
        }
        $email = Email::query()
            ->withTrashed()
            ->updateOrCreate([
                'id' => $request['selectedEmail'],
            ], [
                'to' => implode(',', $request['to'] ?? []),
                'cc' => $request['cc'],
                'bcc' => $request['bcc'],
                'subject' => $request['subject'],
                'content' => $request['content'],
            ]);
        $rule = [
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:2048'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'attachments.*.lte' => 'Attachment size must be less than 2M.',
        ]);
        if ($validator->fails()) {
            $error = '';
            foreach ($validator->errors()->getMessages() as $err) {
                $error = $err[0].'<br>';
            }
            return $error;
        }
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                EmailAttachment::query()
                    ->create([
                        'email_id' => $email['id'],
                        'filename' => $file->getClientOriginalName(),
                        'path' => 'uploads/'.$file->store('attachments'),
                    ]);
            }
        }
        $email->restore();
        return $email;
    }
}
