<div class="content mt-4">
    <h5>{{ count($members) }} members missing credit card profile</h5>
    <table  class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-2">
        <tr>
            <th>Member #</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Plan</th>
        </tr>
        @foreach($members as $member)
            <tr class="bg-white border-b border-slate-300 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td>{{ $member['memberID'] }}</td>
                <td>{{ $member['name'] }}</td>
                <td>{{ $member['phone'] }}</td>
                <td>
                    <a href="mailto:{{ $member['email'] }}" class="underline text-sm text-blue hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $member['email'] }}
                    </a>
                </td>
                <td>{{ $member['plan']['name'] ?? '' }}</td>
            </tr>
        @endforeach
    </table>
</div>
