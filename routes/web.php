<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ItineraryController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\ReviewContrller;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FlightTicketsController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\HottelController;
use App\Http\Controllers\Admin\GalleryRoomController;

/*
|--------------------------------------------------------------------------
| Web Client
|--------------------------------------------------------------------------
|
| These routes are used on the client pages
|
*/
Route::get('/', [ClientController::class, 'index'])->name('index');
Route::prefix('/tours/{slug}')->group(function () {
    Route::get('/', [ClientController::class, 'showTour'])->name('client.tours.detail');
    Route::post('reviews', [ClientController::class, 'storeReview'])->name('client.review.store');
    Route::get('booking', [ClientController::class, 'booking'])->name('client.booking.index');
    Route::post('booking', [ClientController::class, 'storeBooking'])->name('client.booking.store');
    Route::get('/check-room', [ClientController::class, 'checkRoom'])->name('client.booking.check-room');
});         
Route::get('thank-you', [ClientController::class, 'thank'])->name('booking.thank');
Route::get('booking/momo/redirect', [ClientController::class, 'redirectMomo'])->name('booking.momo.redirect');
Route::post('booking/momo/confirm', [ClientController::class, 'confirmMomo'])->name('booking.momo.confirm');


Route::get('/list-tours/{slug}', [ClientController::class, 'listTour'])->name('client.tours.list');
Route::get('/destination', [ClientController::class, 'destination'])->name('client.destination.index');
Route::get('/search', [ClientController::class, 'search'])->name('client.search.index');
Route::get('/contact', [ClientController::class, 'contact'])->name('client.contact.index');
Route::post('/contact', [ClientController::class, 'storeContact'])->name('client.contact.store');
Route::get('coupons/check', [CouponController::class, 'check'])->name('coupons.check');
Route::get('/hottel', [ClientController::class, 'hottel'])->name('client.hottel.index');
Route::get('/flight_tickets', [ClientController::class, 'flight_tickets'])->name('client.flight_tickets.index');
Route::get('/car', [ClientController::class, 'car'])->name('client.car.index');
Route::get('/hottel/detail/{id}', [ClientController::class, 'hotteldetail'])->name('client.hottel.detail');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
|
| These routes are used on the admin pages
|
*/
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('admin.password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('admin.password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('admin.password.update');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/change-password', [ChangePasswordController::class, 'create'])->name('admin.password.change');
        Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('admin.password.store');

        // Destination
        Route::resource('destinations', DestinationController::class)->except(['show']);
        Route::get('destinations/data', [DestinationController::class, 'getData'])->name('destinations.data');

        // Type of tour
        Route::group(['prefix' => 'types'], function () {
            Route::get('/', [TypeController::class, 'index'])->name('types.index');
            Route::post('/', [TypeController::class, 'store'])->name('types.store');
            Route::put('/{id}', [TypeController::class, 'update'])->name('types.update');
            Route::delete('/{id}', [TypeController::class, 'destroy'])->name('types.destroy');
            Route::get('data', [TypeController::class, 'getData'])->name('types.data');
        });

        //Coupon
        Route::prefix('coupons')->group(function () {
            Route::get('/', [CouponController::class, 'index'])->name('coupons.index');
            Route::post('/', [CouponController::class, 'store'])->name('coupons.store');
            Route::put('/{id}', [CouponController::class, 'update'])->name('coupons.update');
            Route::delete('/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
            Route::get('/data', [CouponController::class, 'getData'])->name('coupons.data');
        });

        // Tour
        Route::resource('tours', TourController::class)->except(['show']);
        Route::get('tours/data', [TourController::class, 'getData'])->name('tours.data');
        Route::group(['prefix' => 'tours/{tour_id}'], function () {
            //Addition Info
            Route::get('addition-info', [TourController::class, 'info'])->name('tours.info');

            // List image (Gallery)
            Route::prefix('galleries')->group(function () {
                Route::get('/', [GalleryController::class, 'index'])->name('galleries.index');
                Route::post('/', [GalleryController::class, 'store'])->name('galleries.store');
                Route::delete('/{id}', [GalleryController::class, 'destroy'])->name('galleries.destroy');
            });

            // Itinerary
            Route::prefix('itineraries')->group(function () {
                Route::get('/', [ItineraryController::class, 'index'])->name('itineraries.index');
                Route::post('/', [ItineraryController::class, 'store'])->name('itineraries.store');
                Route::put('/{id}', [ItineraryController::class, 'update'])->name('itineraries.update');
                Route::delete('/{id}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');
                Route::get('/data', [ItineraryController::class, 'getData'])->name('itineraries.data');

                // Place
                Route::prefix('/{itinerary_id}')->group(function () {
                    Route::resource('places', PlaceController::class)->except(['show']);
                    Route::get('places/data', [PlaceController::class, 'getData'])->name('places.data');
                });
            });

            // Room
            Route::prefix('rooms')->group(function () {
                Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
                Route::post('/', [RoomController::class, 'store'])->name('rooms.store');
                Route::put('/{id}', [RoomController::class, 'update'])->name('rooms.update');
                Route::delete('/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');
                Route::get('/data', [RoomController::class, 'getData'])->name('rooms.data');
            });
            // List image (GalleryRoom)
            Route::prefix('galleries_room')->group(function () {
                Route::get('/', [GalleryRoomController::class, 'index'])->name('galleries_room.index');
                Route::post('/', [GalleryRoomController::class, 'store'])->name('galleries_room.store');
                Route::delete('/{id}', [GalleryRoomController::class, 'destroy'])->name('galleries_room.destroy');
            });
            
            // FAQ
            Route::resource('faqs', FAQController::class)->except(['show']);
            Route::get('faqs/data', [FAQController::class, 'getData'])->name('faqs.data');

            // Review
            Route::prefix('reviews')->group(function () {
                Route::get('/', [ReviewContrller::class, 'index'])->name('reviews.index');
                Route::get('/data', [ReviewContrller::class, 'getData'])->name('reviews.data');
                Route::put('/{review_id}/status', [ReviewContrller::class, 'changeStatus'])->name('reviews.status');
            });
            // // FlightTickets
            // Route::prefix('flight_ticket')->group(function () {
            //     Route::get('/', [FlightTicketsController::class, 'index'])->name('flight_tickets.index');
            //     Route::get('/create', [FlightTicketsController::class, 'create'])->name('flight_tickets.create');
            //     Route::post('/', [FlightTicketsController::class, 'store'])->name('flight_tickets.store');
            //     Route::get('/edit/{id}', [FlightTicketsController::class, 'edit'])->name('flight_tickets.edit');
            //     Route::put('/{id}', [FlightTicketsController::class, 'update'])->name('flight_tickets.update');
            //     Route::delete('/{id}', [FlightTicketsController::class, 'destroy'])->name('flight_tickets.destroy');
            //     Route::get('/data', [FlightTicketsController::class, 'getData'])->name('flight_tickets.data');
            // });
            // Car
            // Route::prefix('cars')->group(function () {
            //     Route::get('/', [CarController::class, 'index'])->name('cars.index');
            //     Route::get('/create', [CarController::class, 'create'])->name('cars.create');
            //     Route::post('/', [CarController::class, 'store'])->name('cars.store');
            //     Route::get('/edit/{id}', [CarController::class, 'edit'])->name('cars.edit');
            //     Route::put('/{id}', [CarController::class, 'update'])->name('cars.update');
            //     Route::delete('/{id}', [CarController::class, 'destroy'])->name('cars.destroy');
            //     Route::get('/data', [CarController::class, 'getData'])->name('cars.data');
            // });
        });

        Route::get('/hottels/{id}/book', [HottelController::class, 'order'])->name('hottels.book');
        Route::post('/hottels', [HottelController::class, 'store'])->name('hottels.store');
        Route::get('/hottels/list', [HottelController::class, 'index'])->name('hottels.index');
        // FlightTickets
        Route::prefix('flight_tickets')->group(function () {
            Route::get('/', [FlightTicketsController::class, 'index'])->name('flight_tickets.index');
            Route::get('/create', [FlightTicketsController::class, 'create'])->name('flight_tickets.create');
            Route::post('/', [FlightTicketsController::class, 'store'])->name('flight_tickets.store');
            Route::get('/edit/{id}', [FlightTicketsController::class, 'edit'])->name('flight_tickets.edit');
            Route::put('/{id}', [FlightTicketsController::class, 'update'])->name('flight_tickets.update');
            Route::delete('/{id}', [FlightTicketsController::class, 'destroy'])->name('flight_tickets.destroy');
        });
        // Hiển thị form đặt vé
        Route::get('/flight-tickets/{id}/book', [FlightTicketsController::class, 'book'])->name('flight-tickets.book');
        // Xử lý đặt vé
        Route::post('/flight-tickets/{id}/book', [FlightTicketsController::class, 'storeBooking'])->name('flight-tickets.book.store');
        Route::get('/admin/booked-flights', [FlightTicketsController::class, 'showBookedFlights'])->name('booked_flights.index');
        // Car
        Route::prefix('cars')->group(function () {
            Route::get('/', [CarController::class, 'index'])->name('cars.index');
            Route::get('/create', [CarController::class, 'create'])->name('cars.create');
            Route::post('/', [CarController::class, 'store'])->name('cars.store');
            Route::get('/edit/{id}', [CarController::class, 'edit'])->name('cars.edit');
            Route::put('/{id}', [CarController::class, 'update'])->name('cars.update');
            Route::delete('/{id}', [CarController::class, 'destroy'])->name('cars.destroy');
        });
        // Route cho việc đặt xe
        Route::get('/cars/order/{id}', [CarController::class, 'order'])->name('cars.order');
        Route::post('/cars/confirm-order/{id}', [CarController::class, 'confirmOrder'])->name('cars.confirmOrder');
        Route::get('/cars/rented', [CarController::class, 'rentedCars'])->name('cars.rented');
        

        // Booking
        Route::prefix('bookings')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
            Route::get('/show/{id}', [BookingController::class, 'show'])->name('bookings.show');
            Route::put('/{id}/change-status', [BookingController::class, 'changeStatus'])->name('bookings.status');
            Route::put('/{id}/deposit', [BookingController::class, 'updateDeposit'])->name('bookings.deposit');
            Route::put('/{id}/update', [BookingController::class, 'update'])->name('bookings.update');
            Route::get('/{id}/invoice', [BookingController::class, 'downloadInvoice'])->name('bookings.invoice');
            Route::get('/data', [BookingController::class, 'getData'])->name('bookings.data');
        });

        // Contact
        Route::prefix('contacts')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
            Route::get('/show/{id}', [ContactController::class, 'show'])->name('contacts.show');
            Route::get('/data', [ContactController::class, 'getData'])->name('contacts.data');
        });

        Route::get('bookings/chart', [BookingController::class, 'getChartData'])->name('bookings.chart');
        Route::get('tours/chart', [TourController::class, 'getChartData'])->name('tours.chart');
        Route::get('rooms/chart', [RoomController::class, 'getChartData'])->name('rooms.chart');
        Route::get('rooms/list-room', [RoomController::class, 'getRoomByTourId'])->name('rooms.list');
    });
});
