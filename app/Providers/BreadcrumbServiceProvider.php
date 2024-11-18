<?php

namespace App\Providers;

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Home
        Breadcrumbs::for('home.index', function (BreadcrumbTrail $trail) {
            $trail->push('Home', route('home.index'));
        });

        // Lessons
        Breadcrumbs::for('lesson.index', function (BreadcrumbTrail $trail) {
            $trail->parent('home.index');
            $trail->push('Lessons', route('lesson.index'));
        });

        Breadcrumbs::for('lesson.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('lesson.index');
            $trail->push("Lesson $id", route('lesson.show', $id));
        });

        // Orders
        Breadcrumbs::for('order.index', function (BreadcrumbTrail $trail) {
            $trail->parent('home.index');
            $trail->push('Orders', route('order.index'));
        });

        Breadcrumbs::for('order.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('order.index');
            $trail->push("Order $id", route('order.show', $id));
        });

        Breadcrumbs::for('order.create', function (BreadcrumbTrail $trail) {
            $trail->parent('order.index');
            $trail->push('Create Order', route('order.create'));
        });

        // Instruments
        Breadcrumbs::for('instrument.index', function (BreadcrumbTrail $trail) {
            $trail->parent('home.index');
            $trail->push('Instruments', route('instrument.index'));
        });

        Breadcrumbs::for('instrument.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('instrument.index');
            $trail->push("Instrument $id", route('instrument.show', $id));
        });

        // Stock
        Breadcrumbs::for('stock.index', function (BreadcrumbTrail $trail) {
            $trail->parent('home.index');
            $trail->push('Stock', route('stock.index'));
        });

        Breadcrumbs::for('stock.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('stock.index');
            $trail->push("Stock $id", route('stock.show', $id));
        });

        // Reviews
        Breadcrumbs::for('review.create', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('instrument.show', $id);
            $trail->push('Create Review', route('review.create', $id));
        });

        Breadcrumbs::for('review.save', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('instrument.show', $id);
            $trail->push('Save Review', route('review.save', $id));
        });

        // Cart
        Breadcrumbs::for('cart.index', function (BreadcrumbTrail $trail) {
            $trail->parent('home.index');
            $trail->push('Cart', route('cart.index'));
        });

        // Admin
        Breadcrumbs::for('admin.index', function (BreadcrumbTrail $trail) {
            $trail->parent('home.index');
            $trail->push('Admin', route('admin.index'));
        });

        Breadcrumbs::for('admin.lesson.index', function (BreadcrumbTrail $trail) {
            $trail->parent('admin.index');
            $trail->push('Lessons', route('admin.lesson.index'));
        });

        Breadcrumbs::for('admin.lesson.create', function (BreadcrumbTrail $trail) {
            $trail->parent('admin.lesson.index');
            $trail->push('Create Lesson', route('admin.lesson.create'));
        });

        Breadcrumbs::for('admin.lesson.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('admin.lesson.index');
            $trail->push("Lesson $id", route('admin.lesson.show', $id));
        });

        Breadcrumbs::for('admin.instrument.index', function (BreadcrumbTrail $trail) {
            $trail->parent('admin.index');
            $trail->push('Instruments', route('admin.instrument.index'));
        });

        Breadcrumbs::for('admin.instrument.create', function (BreadcrumbTrail $trail) {
            $trail->parent('admin.instrument.index');
            $trail->push('Create Instrument', route('admin.instrument.create'));
        });

        Breadcrumbs::for('admin.instrument.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('admin.instrument.index');
            $trail->push("Instrument $id", route('admin.instrument.show', $id));
        });

        Breadcrumbs::for('admin.stock.index', function (BreadcrumbTrail $trail) {
            $trail->parent('admin.index');
            $trail->push('Stock2', route('admin.stock.index'));
        });

        Breadcrumbs::for('admin.stock.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('admin.stock.index');
            $trail->push("Stock $id", route('admin.stock.show', $id));
        });

        Breadcrumbs::for('admin.order.index', function (BreadcrumbTrail $trail) {
            $trail->parent('admin.index');
            $trail->push("Order", route('admin.order.index'));
        });

        Breadcrumbs::for('admin.order.show', function (BreadcrumbTrail $trail, $id) {
            $trail->parent('admin.order.index');
            $trail->push("Order $id", route('admin.order.show', $id));
        });
    }
}
