<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});

// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User Management', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Users', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Roles', route('user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permission
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Permissions', route('user-management.permissions.index'));
});

// Home > Dashboard > Members
Breadcrumbs::for('members.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Members', '#');
});

// NWC Members
Breadcrumbs::for('members.nwc.index', function (BreadcrumbTrail $trail) {
    $trail->parent('members.index');
    $trail->push('NWC Members', route('members.nwc.index'));
});

Breadcrumbs::for('members.nwc.create', function (BreadcrumbTrail $trail) {
    $trail->parent('members.nwc.index');
    $trail->push('Add Member', route('members.nwc.create'));
});

Breadcrumbs::for('members.nwc.show', function (BreadcrumbTrail $trail, $member) {
    $trail->parent('members.nwc.index');
    $trail->push("{$member->firstname} {$member->surname}", route('members.nwc.show', $member));
});

Breadcrumbs::for('members.nwc.edit', function (BreadcrumbTrail $trail, $member) {
    $trail->parent('members.nwc.show', $member);
    $trail->push('Edit', route('members.nwc.edit', $member));
});

// NEC Members
Breadcrumbs::for('members.nec.index', function (BreadcrumbTrail $trail) {
    $trail->parent('members.index');
    $trail->push('NEC Members', route('members.nec.index'));
});

Breadcrumbs::for('members.nec.create', function (BreadcrumbTrail $trail) {
    $trail->parent('members.nec.index');
    $trail->push('Add Member', route('members.nec.create'));
});

Breadcrumbs::for('members.nec.show', function (BreadcrumbTrail $trail, $member) {
    $trail->parent('members.nec.index');
    $trail->push("{$member->firstname} {$member->surname}", route('members.nec.show', $member));
});

Breadcrumbs::for('members.nec.edit', function (BreadcrumbTrail $trail, $member) {
    $trail->parent('members.nec.show', $member);
    $trail->push('Edit', route('members.nec.edit', $member));
});

// DEPs Members
Breadcrumbs::for('members.deps.index', function (BreadcrumbTrail $trail) {
    $trail->parent('members.index');
    $trail->push('DEPs Members', route('members.deps.index'));
});

Breadcrumbs::for('members.deps.create', function (BreadcrumbTrail $trail) {
    $trail->parent('members.deps.index');
    $trail->push('Add Member', route('members.deps.create'));
});

Breadcrumbs::for('members.deps.show', function (BreadcrumbTrail $trail, $member) {
    $trail->parent('members.deps.index');
    $trail->push("{$member->firstname} {$member->surname}", route('members.deps.show', $member));
});

Breadcrumbs::for('members.deps.edit', function (BreadcrumbTrail $trail, $member) {
    $trail->parent('members.deps.show', $member);
    $trail->push('Edit', route('members.deps.edit', $member));
});

// Home > Dashboard > Meetings
Breadcrumbs::for('meetings.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Meetings', route('meetings.index'));
});

Breadcrumbs::for('meetings.create', function (BreadcrumbTrail $trail) {
    $trail->parent('meetings.index');
    $trail->push('Add Meeting', route('meetings.create'));
});

Breadcrumbs::for('meetings.show', function (BreadcrumbTrail $trail, $meeting) {
    $trail->parent('meetings.index');
    $trail->push($meeting->title, route('meetings.show', $meeting));
});

Breadcrumbs::for('meetings.edit', function (BreadcrumbTrail $trail, $meeting) {
    $trail->parent('meetings.show', $meeting);
    $trail->push('Edit', route('meetings.edit', $meeting));
});

Breadcrumbs::for('meetings.attendance-scan', function (BreadcrumbTrail $trail, $meeting) {
    $trail->parent('meetings.index');
    $trail->push($meeting->title, route('meetings.show', $meeting));
    $trail->push('Check-In', route('meetings.attendance-scan', $meeting));
});
