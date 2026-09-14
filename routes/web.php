<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandingController;
use App\Http\Controllers\Admin\CompanySettingController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataCentreController as AdminDataCentreController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SolutionController as AdminSolutionController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DataCentreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/solutions', [SolutionController::class, 'index'])->name('solutions.index');
Route::get('/solutions/{solution:slug}', [SolutionController::class, 'show'])->name('solutions.show');
Route::get('/projects', [DataCentreController::class, 'index'])->name('data-centre.index');
Route::get('/projects/{dataCentre:slug}', [DataCentreController::class, 'show'])->name('data-centre.show');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms-of-service', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/cookie-policy', [LegalController::class, 'cookies'])->name('legal.cookies');
Route::get('/sitemap', [LegalController::class, 'sitemap'])->name('legal.sitemap');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/settings/company', [CompanySettingController::class, 'edit'])->name('settings.company');
        Route::put('/settings/company', [CompanySettingController::class, 'update']);
        Route::get('/settings/branding', [BrandingController::class, 'edit'])->name('settings.branding');
        Route::put('/settings/branding', [BrandingController::class, 'update']);
        Route::get('/settings/website', [WebsiteSettingController::class, 'edit'])->name('settings.website');
        Route::put('/settings/website', [WebsiteSettingController::class, 'update']);
        Route::get('/settings/social-links', [SocialLinkController::class, 'index'])->name('settings.social-links');
        Route::post('/settings/social-links', [SocialLinkController::class, 'store']);
        Route::put('/settings/social-links/{socialLink}', [SocialLinkController::class, 'update'])->name('settings.social-links.update');
        Route::delete('/settings/social-links/{socialLink}', [SocialLinkController::class, 'destroy'])->name('settings.social-links.destroy');
        Route::patch('/settings/social-links/{socialLink}/toggle', [SocialLinkController::class, 'toggle'])->name('settings.social-links.toggle');

        Route::get('/content/homepage', [HomepageController::class, 'edit'])->name('content.homepage');
        Route::put('/content/homepage', [HomepageController::class, 'update']);
        Route::post('/content/homepage/benefits', [HomepageController::class, 'storeBenefit'])->name('content.homepage.benefits.store');
        Route::put('/content/homepage/benefits/{benefit}', [HomepageController::class, 'updateBenefit'])->name('content.homepage.benefits.update');
        Route::delete('/content/homepage/benefits/{benefit}', [HomepageController::class, 'destroyBenefit'])->name('content.homepage.benefits.destroy');
        Route::post('/content/homepage/statistics', [HomepageController::class, 'storeStatistic'])->name('content.homepage.statistics.store');
        Route::put('/content/homepage/statistics/{statistic}', [HomepageController::class, 'updateStatistic'])->name('content.homepage.statistics.update');
        Route::delete('/content/homepage/statistics/{statistic}', [HomepageController::class, 'destroyStatistic'])->name('content.homepage.statistics.destroy');

        Route::get('/content/about', [AdminAboutController::class, 'edit'])->name('content.about');
        Route::put('/content/about', [AdminAboutController::class, 'update']);
        Route::post('/content/about/values', [AdminAboutController::class, 'storeValue'])->name('content.about.values.store');
        Route::put('/content/about/values/{value}', [AdminAboutController::class, 'updateValue'])->name('content.about.values.update');
        Route::delete('/content/about/values/{value}', [AdminAboutController::class, 'destroyValue'])->name('content.about.values.destroy');

        Route::resource('blog-categories', AdminBlogCategoryController::class)->except(['show']);
        Route::patch('/blog-categories/{blogCategory}/toggle', [AdminBlogCategoryController::class, 'toggleStatus'])->name('blog-categories.toggle');
        Route::resource('blog-posts', AdminBlogPostController::class)->except(['show']);
        Route::patch('/blog-posts/{blogPost}/toggle', [AdminBlogPostController::class, 'toggleStatus'])->name('blog-posts.toggle');

        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::patch('/services/{service}/toggle', [AdminServiceController::class, 'toggleStatus'])->name('services.toggle');

        Route::resource('solutions', AdminSolutionController::class)->except(['show']);
        Route::patch('/solutions/{solution}/toggle', [AdminSolutionController::class, 'toggleStatus'])->name('solutions.toggle');

        Route::get('/data-centres', [AdminDataCentreController::class, 'index'])->name('data-centres.index');
        Route::get('/data-centres/create', [AdminDataCentreController::class, 'create'])->name('data-centres.create');
        Route::post('/data-centres', [AdminDataCentreController::class, 'store'])->name('data-centres.store');
        Route::get('/data-centres/{dataCentre}/edit', [AdminDataCentreController::class, 'edit'])->name('data-centres.edit');
        Route::put('/data-centres/{dataCentre}', [AdminDataCentreController::class, 'update'])->name('data-centres.update');
        Route::delete('/data-centres/{dataCentre}', [AdminDataCentreController::class, 'destroy'])->name('data-centres.destroy');
        Route::patch('/data-centres/{dataCentre}/toggle', [AdminDataCentreController::class, 'toggleStatus'])->name('data-centres.toggle');
        Route::post('/data-centres/{dataCentre}/specifications', [AdminDataCentreController::class, 'storeSpecification'])->name('data-centres.specifications.store');
        Route::put('/data-centres/{dataCentre}/specifications/{specification}', [AdminDataCentreController::class, 'updateSpecification'])->name('data-centres.specifications.update');
        Route::delete('/data-centres/{dataCentre}/specifications/{specification}', [AdminDataCentreController::class, 'destroySpecification'])->name('data-centres.specifications.destroy');
        Route::post('/data-centres/{dataCentre}/features', [AdminDataCentreController::class, 'storeFeature'])->name('data-centres.features.store');
        Route::put('/data-centres/{dataCentre}/features/{feature}', [AdminDataCentreController::class, 'updateFeature'])->name('data-centres.features.update');
        Route::delete('/data-centres/{dataCentre}/features/{feature}', [AdminDataCentreController::class, 'destroyFeature'])->name('data-centres.features.destroy');
        Route::get('/data-centres/{dataCentre}/gallery', [AdminDataCentreController::class, 'gallery'])->name('data-centres.gallery');
        Route::post('/data-centres/{dataCentre}/gallery', [AdminDataCentreController::class, 'storeGallery'])->name('data-centres.gallery.store');
        Route::delete('/data-centres/{dataCentre}/gallery/{gallery}', [AdminDataCentreController::class, 'destroyGallery'])->name('data-centres.gallery.destroy');
        Route::patch('/data-centres/{dataCentre}/gallery/{gallery}/toggle', [AdminDataCentreController::class, 'toggleGallery'])->name('data-centres.gallery.toggle');

        Route::get('/contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
        Route::get('/contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
        Route::patch('/contact-submissions/{contactSubmission}/status', [ContactSubmissionController::class, 'updateStatus'])->name('contact-submissions.status');
        Route::delete('/contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');

        Route::get('/media', [MediaController::class, 'index'])->name('media.index');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update']);
    });
});
