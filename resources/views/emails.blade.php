<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap5/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/quill/katex.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/quill/editor.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/emails.css') }}" />
    @endpush

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900">
            @php
                if ($message = session('success_message')) $color = 'success';
                else if ($message = session('info_message')) $color = 'info';
                else if ($message = session('warning_message')) $color = 'warning';
                else if ($message = session('error_message')) $color = 'danger';
            @endphp
            @if ($message)
                <div class="alert alert-{{ $color }} alert-dismissible" role="alert">
                    {!! $message !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="app-email card">
                <div class="row g-0">
                    <!-- Email Sidebar -->
                    <div id="app-email-sidebar" class="col app-email-sidebar border-end flex-grow-0">
                        <div class="btn-compost-wrapper d-grid">
                            <button class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#emailCompose" id="emailComposeLabel"
                                    v-on:click="openNewEmail">
                                Compose
                            </button>
                        </div>
                        <!-- Email Filters -->
                        <div class="email-filters py-2">
                            <!-- Email Filters: Folder -->
                            <ul class="email-filter-folders list-unstyled mb-4">
                                <li data-target="sent" @class(['d-flex', 'active' => $type == 'sent'])>
                                    <a href="{{ route('emails.sent') }}" class="d-flex flex-wrap align-items-center">
                                        <i class="ti ti-send ti-sm"></i>
                                        <span class="align-middle ms-2">Sent</span>
                                    </a>
                                </li>
                                <li data-target="draft" @class(['d-flex', 'active' => $type == 'draft'])>
                                    <a href="{{ route('emails.draft') }}" class="d-flex flex-wrap align-items-center">
                                        <i class="ti ti-file ti-sm"></i>
                                        <span class="align-middle ms-2">Draft</span>
                                    </a>
                                </li>
                                <li data-target="trash" @class(['d-flex', 'active' => $type == 'trash'])>
                                    <a href="{{ route('emails.trash') }}" class="d-flex flex-wrap align-items-center">
                                        <i class="ti ti-trash ti-sm"></i>
                                        <span class="align-middle ms-2">Trash</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Email Sidebar -->

                    <!-- Emails List -->
                    <div class="col app-emails-list">
                        <div class="shadow-none border-0">
                            <div class="emails-list-header p-3 py-lg-3 py-2">
                                <!-- Email List: Search -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center w-100">
                                        <i id="app-email-sidebar-toggle" class="ti ti-menu-2 ti-sm cursor-pointer d-block d-lg-none me-3"></i>
                                        <div class="w-100">
                                            <div class="input-group input-group-merge shadow-none">
                                                <label for="email-search" class="input-group-text border-0 ps-0">
                                                    <i class="ti ti-search ti-sm"></i>
                                                </label>
                                                <input type="text" id="email-search" class="form-control email-search-input border-0"
                                                       v-model="keyword"
                                                       placeholder="Search mail" aria-label="Search mail"
                                                       aria-describedby="email-search">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="container-m-nx m-0">
                            <div class="email-list pt-0">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th colspan="4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check min-h-auto mb-0">
                                                        <input type="checkbox" id="email-select-all" class="form-check-input"
                                                               v-model="selectedAll"
                                                               v-on:change="e => selectAll(e.target.checked)">
                                                        <label for="email-select-all" class="form-check-label"></label>
                                                    </div>
                                                    <i class="ti ti-trash ti-sm cursor-pointer me-2"
                                                       title="Delete @if ($type == 'trash') Forever @endif"
                                                       :class="{'text-muted': !selectedItems.length}"
                                                       v-on:click="deleteSelectedItems"></i>
                                                    @if ($type === 'trash')
                                                        <i class="ti ti-arrow-back-up ti-sm cursor-pointer me-2" title="Restore"
                                                           :class="{'text-muted': !selectedItems.length}"
                                                           v-on:click="restoreSelectedItems"></i>
                                                    @endif
                                                </div>
                                                <div class="email-pagination d-sm-flex d-none align-items-center flex-wrap justify-content-between justify-sm-content-end">
                                                    <span class="d-sm-block d-none mx-3 text-muted"
                                                        v-text="paginationInfo"></span>
                                                    <i class="ti ti-chevron-left ti-sm cursor-pointer me-2"
                                                       :class="{'text-muted': isFirstPage}"
                                                       v-on:click="prevPage"></i>
                                                    <i class="ti ti-chevron-right ti-sm cursor-pointer"
                                                       :class="{'text-muted': isLastPage}"
                                                       v-on:click="nextPage"></i>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="email-list-item" v-for="(email, index) in pageEmails" key="index">
                                        <td class="pe-0" style="width: 30px;">
                                            <div class="form-check mb-0">
                                                <input type="checkbox" class="email-list-item-input form-check-input"
                                                       :id="`email-${email.id}`"
                                                       :checked="selectedItems.includes(email.id)"
                                                       v-on:change="e => selectItem(email, e.target.checked)">
                                                <label class="form-check-label" :for="`email-${email.id}`"></label>
                                            </div>
                                        </td>
                                        <td class="email-list-item-content cursor-pointer px-1" v-on:click="openEmail(email)">
                                            <span class="h6 email-list-item-username"
                                                  v-text="email.subject ? email.subject : '(no subject)'"></span>
                                            <span v-if="email.attachments.length">
                                                <i class="ti ti-paperclip ti-sm ms-2"></i>
                                            </span>
                                        </td>
                                        <td class="email-list-item-content cursor-pointer px-1" v-on:click="openEmail(email)">
                                            <span class="h6 email-list-item-username"
                                                  v-text="`To: ${email.to[0]?.email || ''} ${email.to?.length > 1 ? ` and ${email.to.length - 1} others` : ''}`"></span>
                                        </td>
                                        <td class="ps-0" style="width: 180px;">
                                            <div class="email-list-item-meta d-flex align-items-center justify-content-end">
                                                <small class="email-list-item-time text-muted"
                                                       v-text="email.sent_at ?? email.updated_at"></small>
                                                <ul class="email-list-item-actions list-inline text-nowrap m-0">
                                                    @if ($type == 'trash')
                                                        <li class="list-inline-item cursor-pointer"
                                                            v-on:click="restoreItem(email.id)">
                                                            <i class='ti ti-arrow-back-up ti-sm'></i>
                                                        </li>
                                                    @endif
                                                    <li class="list-inline-item cursor-pointer"
                                                        v-on:click="deleteItem(email.id)">
                                                        <i class='ti ti-trash ti-sm'></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!pageEmails.length">
                                        <td colspan="4" class="email-list-empty text-center">
                                            No items found.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="app-overlay"></div>
                    </div>
                    <!-- /Emails List -->

                    <!-- Email View -->
                    <div id="app-email-view" class="col app-email-view flex-grow-0 bg-body">
                        <div class="card shadow-none border-0 rounded-0 app-email-view-header p-3 pt-md-3 py-2 pb-0">
                            <!-- Email View : Title  bar-->
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <i class="ti ti-chevron-left ti-sm cursor-pointer me-2"
                                       v-on:click="closeEmail"></i>
                                    <h6 class="text-truncate mb-0 me-2"
                                        v-text="openedEmail.subject ? openedEmail.subject : '(no subject)'"></h6>
                                </div>
                                <!-- Email View : Action  bar-->
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-trash ti-sm cursor-pointer"
                                       v-on:click="deleteEmail"></i>
                                </div>
                            </div>
                            <hr class="app-email-view-hr mx-n3 mb-0">
                        </div>
                        <!-- Email View : Content-->
                        <div class="app-email-view-content py-4">
                            <div class="card mx-sm-4 mx-3 mt-4">
                                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="d-flex align-items-center mb-sm-0 mb-3">
                                        <h6 class="m-0">To:</h6>
                                        <div class="flex-grow-1 ms-1">
                                            <a class="text-muted d-block"
                                               v-for="(to, index) in openedEmail.to" key="index"
                                               :href="`mailto:${to.email}`" v-text="to.email"></a>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 me-3 text-muted" v-text="openedEmail.sent_at"></p>
                                        <i class="ti ti-paperclip ti-sm" v-if="openedEmail.attachments.length"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="email-content" v-html="openedEmail.content"></div>
                                    <div class="email-attachments-list" v-if="openedEmail.attachments.length">
                                        <hr>
                                        <p class="email-attachment-title mb-2">Attachments</p>
                                        <div class="email-attachment"
                                             v-for="(file, index) in openedEmail.attachments" key="index">
                                            <i class="ti ti-file ti-sm"></i>
                                            <span class="align-middle ms-1" v-text="file.filename"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Email View -->
                </div>

                <!-- Compose Email -->
                <div id="emailCompose" class="app-email-compose modal"
                     tabindex="-1" aria-labelledby="emailComposeLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg m-0 me-md-4 mb-4">
                        <div class="modal-content p-0">
                            <div class="modal-header py-3 bg-body">
                                <h5 class="modal-title fs-5">Compose Mail</h5>
                                <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex-grow-1 pb-sm-0 p-4 py-2">
                                <form id="app-email-compose-form" class="email-compose-form"
                                      name="emailComposeForm"
                                      action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="selectedEmail" :value="openedEmail.id || ''">
                                    <div class="email-compose-to d-flex justify-content-between align-items-center">
                                        <label for="email-to" class="form-label mb-0">To:</label>
                                        <div class="select2-primary border-0 shadow-none flex-grow-1 px-2">
                                            <select id="email-to" class="select2 select-email-contacts form-select"
                                                    name="to[]" multiple>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member['id'] }}">{{ $member['name'] }}, {{ $member['email'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="email-compose-toggle-wrapper">
                                            <a class="email-compose-toggle-cc me-1" href="javascript:void(0);">Cc |</a>
                                            <a class="email-compose-toggle-bcc" href="javascript:void(0);">Bcc</a>
                                        </div>
                                    </div>

                                    <div class="email-compose-cc" style="display: none;">
                                        <hr class="container-m-nx my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="email-cc" class="form-label mb-0">Cc: </label>
                                            <input type="text" class="form-control border-0 shadow-none flex-grow-1 mx-2"
                                                   id="email-cc" name="cc" placeholder="someone@email.com"
                                                   :value="openedEmail.cc || ''">
                                        </div>
                                    </div>
                                    <div class="email-compose-bcc" style="display: none;">
                                        <hr class="container-m-nx my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="email-bcc" class="form-label mb-0">Bcc: </label>
                                            <input type="text" class="form-control border-0 shadow-none flex-grow-1 mx-2"
                                                   id="email-bcc" name="bcc" placeholder="someone@email.com"
                                                   :value="openedEmail.bcc || ''">
                                        </div>
                                    </div>
                                    <hr class="container-m-nx my-2">
                                    <div class="email-compose-subject d-flex align-items-center mb-2">
                                        <input type="text" class="form-control border-0 shadow-none flex-grow-1 px-2"
                                               id="email-subject" name="subject" placeholder="Subject"
                                               :value="openedEmail.subject || ''">
                                    </div>
                                    <div class="email-compose-message container-m-nx">
                                        <div class="d-flex justify-content-end">
                                            <div class="email-editor-toolbar border-bottom-0 w-100">
                                                <span class="ql-formats me-0">
                                                    <button class="ql-bold"></button>
                                                    <button class="ql-italic"></button>
                                                    <button class="ql-underline"></button>
                                                    <button class="ql-list" value="ordered"></button>
                                                    <button class="ql-list" value="bullet"></button>
                                                    <button class="ql-link"></button>
                                                    <button class="ql-image"></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="email-editor"></div>
                                        <textarea name="content" id="email-content" class="d-none"
                                                  :value="openedEmail.content || ''" style="display: none;"></textarea>
                                    </div>
                                    <hr class="container-m-nx mt-0 mb-2">
                                    <div class="email-attachments-list">
                                        <div class="d-flex justify-content-between align-items-center small bg-light p-1 mt-1"
                                             v-for="(attach, index) in openedEmail.attachments" key="index">
                                            <span v-text="attach.filename"></span>
                                            <span class="cursor-pointer" v-on:click="deleteAttach(attach.id)">
                                                <i class="ti ti-x ti-sm"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center small bg-light p-1 mt-1"
                                             v-for="(attach, index) in attachments" key="index">
                                            <span v-text="attach"></span>
                                        </div>
                                    </div>
                                    <div class="email-compose-actions d-flex justify-content-between align-items-center my-3">
                                        <div class="d-flex align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary"
                                                        v-on:click="sendMail">
                                                    <i class="ti ti-send ti-xs me-1"></i>Send
                                                </button>
                                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="visually-hidden">Send Options</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                           v-on:click="saveDraft">
                                                            Save draft
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <label for="attach-file"><i class="ti ti-paperclip cursor-pointer ms-2"></i></label>
                                            <input type="file" id="attach-file" name="attachments[]" class="d-none" multiple
                                                   v-on:change="selectAttachments">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn" title="Discard draft"
                                                    data-bs-dismiss="modal" aria-label="Close"
                                                    v-on:click="discardDraft">
                                                <i class="ti ti-trash ti-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Compose Email -->
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap5/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
        <script src="{{ asset('assets/vendor/quill/katex.js') }}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>

        <script type="module">
            const { createApp, ref, computed, watch } = Vue;

            createApp({
                setup() {
                    const emails = ref({!! $emails !!});
                    const keyword = ref('');
                    const filteredEmails = computed(() => {
                        return emails.value.filter(email => {
                            const q = keyword.value.toLowerCase();
                            return email.subject.toLowerCase().includes(q)
                                || email.to.find(el => el.email.toLowerCase().includes(q));
                        });
                    });
                    const per_page = 10;
                    const page = ref(1);
                    watch(keyword, () => page.value = 1);
                    const pageEmails = computed(() => {
                        return filteredEmails.value.filter((email, index) => {
                            return (page.value - 1) * per_page <= index
                                && index < Math.min(page.value * per_page, filteredEmails.value.length);
                        });
                    });
                    const paginationInfo = computed(() => {
                        const total = filteredEmails.value.length;
                        if (!total) return '';
                        const from = (page.value - 1) * per_page + 1;
                        const to = Math.min(page.value * per_page, total);
                        return `${from}-${to} of ${total}`;
                    });
                    const isFirstPage = computed(() => {
                        return page.value === 1;
                    });
                    const prevPage = () => {
                        if (!isFirstPage.value) page.value--;
                    }
                    const isLastPage = computed(() => {
                        return page.value * per_page >= filteredEmails.value.length;
                    });
                    const nextPage = () => {
                        if (!isLastPage.value) page.value++;
                    }
                    const selectedAll = ref(false);
                    const selectedItems = ref([]);
                    const selectAll = checked => {
                        if (checked) {
                            selectedItems.value = filteredEmails.value
                                .map(email => email.id);
                        } else {
                            selectedItems.value = [];
                        }
                    }
                    const selectItem = (item, checked) => {
                        if (checked) {
                            selectedItems.value = [
                                ...selectedItems.value.filter(el => el <= item.id),
                                item.id,
                                ...selectedItems.value.filter(el => el > item.id),
                            ];
                        } else {
                            selectedItems.value = selectedItems.value.filter(el => el !== item.id);
                        }
                        selectedAll.value = selectedItems.value.length === filteredEmails.value.length;
                    }
                    const deleteItem = email => {
                        sendActionRequest([email]);
                    }
                    const deleteSelectedItems = () => {
                        if (selectedItems.value.length) {
                            sendActionRequest(selectedItems.value);
                        }
                    }
                    const restoreItem = email => {
                        sendActionRequest([email], true);
                    }
                    const restoreSelectedItems = () => {
                        if (selectedItems.value.length) {
                            sendActionRequest(selectedItems.value, true);
                        }
                    }
                    const sendActionRequest = (ids, restore) => {
                        $.ajax({
                            url: restore ? '{{ route('emails.restore') }}' : '{{ route('emails.destroy') }}',
                            method: restore ? 'POST' : 'DELETE',
                            data: {
                                type: '{{ $type }}',
                                emails: ids,
                            },
                        });
                        emails.value = emails.value.filter(el => !ids.includes(el.id));
                    }
                    const openedEmail = ref({attachments: []});
                    const emailTo = ref(null);
                    const openNewEmail = () => {
                        openedEmail.value = {attachments: []};
                        emailTo.value.val(null).trigger('change');
                        $('.ql-editor').html('');
                        $('#emailCompose').modal('show');
                    }
                    const openEmail = email => {
                        $.ajax({
                            url: '{{ url('emails') }}/read/' + email.id,
                            method: 'GET',
                            success(email) {
                                openedEmail.value = email;
                                if (email.sent_at) {
                                    $('#app-email-view').addClass('show');
                                } else {
                                    emailTo.value.val(email.to.map(el => el.id)).trigger('change');
                                    $('.ql-editor').html(email.content);
                                    $('#emailCompose').modal('show');
                                }
                            }
                        });
                    }
                    const closeEmail = () => {
                        $('#app-email-view').removeClass('show');
                    }
                    const deleteEmail = () => {
                        if (openedEmail.value.id) {
                            sendActionRequest([openedEmail.value.id]);
                        }
                        closeEmail();
                    }
                    const deleteAttach = id => {
                        $.ajax({
                            url: '{{ route('emails.destroy-attachment') }}',
                            method: 'DELETE',
                            data: {
                                attachment: id,
                            },
                            success() {
                                const email = {...openedEmail.value};
                                email.attachments = email.attachments.filter(el => el.id != id);
                                openedEmail.value = email;
                                emails.value = emails.value.map(el => {
                                    if (el.id == email.id) el.attachments = email.attachments;
                                    return el;
                                });
                            }
                        })
                    }

                    const attachments = ref([]);
                    const selectAttachments = e => {
                        const files = e.target.files;
                        if (!files.length) return attachments.value = [];
                        let attaches = [];
                        for (let i = 0; i < files.length; i++) {
                            attaches.push(files[i].name);
                        }
                        attachments.value = attaches;
                    }
                    const sendMail = () => {
                        if (!$('#email-to').val().length) {
                            return alert('Please specify at least one recipient.');
                        }
                        $('#email-content').val($('.ql-editor').html());
                        $('#app-email-compose-form').attr('action', '{{ route('emails.send') }}').submit();
                    }
                    const saveDraft = () => {
                        $('#email-content').val($('.ql-editor').html());
                        $('#app-email-compose-form').attr('action', '{{ route('emails.save-as-draft') }}').submit();
                    }
                    const discardDraft = () => {
                        //$('#app-email-compose-form').attr('action', '{{ route('emails.discard') }}').submit();
                    }

                    return {
                        keyword, filteredEmails, pageEmails,
                        paginationInfo, isFirstPage, prevPage, isLastPage, nextPage,
                        selectedAll, selectAll, selectedItems, selectItem,
                        deleteItem, deleteSelectedItems, restoreItem, restoreSelectedItems,
                        openedEmail, emailTo, openNewEmail, openEmail, closeEmail, deleteEmail, deleteAttach,
                        attachments, selectAttachments,
                        sendMail, saveDraft, discardDraft,
                    }
                },
                mounted() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    });

                    this.emailTo = $('#email-to').wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $('#email-to').parent(),
                        closeOnSelect: false,
                    });

                    new Quill('.email-editor', {
                        modules: {
                            toolbar: '.email-editor-toolbar'
                        },
                        placeholder: 'Write your message... ',
                        theme: 'snow'
                    });

                    $('#app-email-sidebar-toggle').click(function () {
                        $('#app-email-sidebar').addClass('show');
                        $('.app-overlay').addClass('show');
                    });
                    $('.app-overlay').click(function () {
                        $('#app-email-sidebar').removeClass('show');
                        $('.app-overlay').removeClass('show');
                    });

                    $('.email-compose-toggle-cc').click(function () {
                        $('.email-compose-cc').toggle();
                    });
                    $('.email-compose-toggle-bcc').click(function() {
                        $('.email-compose-bcc').toggle();
                    });
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
