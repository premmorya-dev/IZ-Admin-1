<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// // Home
// Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
//     $trail->push('Home', route('dashboard'));
// });

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dashboard > Users
Breadcrumbs::for('user.list', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('user.list'));
});

// Dashboard > Users > Add User
Breadcrumbs::for('user.add', function (BreadcrumbTrail $trail) {
    $trail->parent('user.list');
    $trail->push('Add User', route('user.add'));
});

// Dashboard > Users > Edit User
Breadcrumbs::for('user.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('user.list');
    $trail->push('Edit User', route('user.edit','user_id'));
});


// Dashboard > Setting
Breadcrumbs::for('program.list', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Program', route('program.list'));
});


// Dashboard > Workshop > Add Workshop
Breadcrumbs::for('program.add', function (BreadcrumbTrail $trail) {
    $trail->parent('program.list');
    $trail->push('Add Program', route('program.add','program_id'));
});

// Dashboard > Registration
Breadcrumbs::for('student_registration.list', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Student Registration', route('student_registration.list'));
});


// Dashboard > Registration > Edit Registration
Breadcrumbs::for('student_registration.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('student_registration.list');
    $trail->push('Edit Student Registration', route('student_registration.edit','student_registration_id'));
});

// Dashboard > Registration Status
Breadcrumbs::for('student_registration.stats', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Registration Stats', route('student_registration.stats'));
});

//   Seo
// Dashboard > Seo Url List
Breadcrumbs::for('seo_url.list', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Seo Url', route('seo_url.list'));
});

// Dashboard > Seo Url List > Seo Url Edit
Breadcrumbs::for('seo_url.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('seo_url.list');
    $trail->push('Seo Url Edit', route('seo_url.edit','seo_url_id'));
});

// Dashboard > Seo Url List > Seo Url Add
Breadcrumbs::for('seo_url.add', function (BreadcrumbTrail $trail) {
    $trail->parent('seo_url.list');
    $trail->push('Seo Url Add', route('seo_url.add'));
});

//end

// Dashboard > Sms Template List
Breadcrumbs::for('sms.list', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Sms Template', route('sms.list'));
});

// Dashboard > Sms Template List > Sms Template Edit
Breadcrumbs::for('sms.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('sms.list');
    $trail->push('Sms Template Edit', route('sms.edit','sms_id'));
});


// Dashboard > Sms Template List > Sms Template Add
Breadcrumbs::for('sms.add', function (BreadcrumbTrail $trail) {
    $trail->parent('sms.list');
    $trail->push('Sms Template Add', route('sms.add'));
});


//   Whatsapp
// Dashboard > Whatsapp List
Breadcrumbs::for('whatsapp.list', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Whatsapp', route('whatsapp.list'));
});

// Dashboard > Whatsapp List > Whatsapp Edit
Breadcrumbs::for('whatsapp.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('whatsapp.list');
    $trail->push('Whatsapp Edit', route('whatsapp.edit','whatsapp_id'));
});

// Dashboard > Whatsapp List > Whatsapp Add
Breadcrumbs::for('whatsapp.add', function (BreadcrumbTrail $trail) {
    $trail->parent('whatsapp.list');
    $trail->push('Whatsapp Add', route('whatsapp.add'));
});

//end




