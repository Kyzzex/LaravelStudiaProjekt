@php
    $statuses = collect([
        'grade-added' => __('Grade added successfully'),
        'grade-edited' => __('Grade edited successfully'),
        'group-deleted' => __('Group and related data were successfully deleted'),
        'group-created' => __('Group created successfully'),
        'user-added' => __('User successfully added to group'),
        'user-removed' => __('User successfully removed from group'),
        'subject-added' => __('Subject successfully added to group'),
        'subject-removed' => __('Subject successfully removed from group'),
        'subject-deleted' => __('Subject and related data were successfully deleted'),
        'user-deleted' => __('User and related data were successfully deleted'),
        'user-created' => __('Created user with temporary password:').' '.session('password')
    ]);
    $status = session('status');
@endphp

@if($status && $statuses->has($status))
    <div class="absolute top-0 right-0 left-0 text-sm bg-green-400 text-center p-2 transition" :class="{'opacity-0': hiding, hidden}" x-data="{ hiding: false, hidden: false }">
        {{ $statuses[$status] }}
    </div>
@endif
