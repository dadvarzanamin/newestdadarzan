@if(!empty($latestVersion) && !empty($latestVersion->url_update))
    <div class="site-version-banner" data-version="{{ $latestVersion->version }}">
        <div class="container">
            <div class="site-version-banner__content">
                <div class="site-version-banner__text">
                    نسخه جدید اپلیکیشن آماده است
                    <span class="site-version-banner__badge">نسخه {{ $latestVersion->version }}</span>
                </div>
                <div class="site-version-banner__actions">
                    <a class="site-version-banner__download" href="{{ $latestVersion->url_update }}" target="_blank" rel="noopener">
                        دانلود نسخه جدید
                    </a>
                    <button type="button" class="site-version-banner__close" aria-label="بستن بنر">×</button>
                </div>
            </div>
        </div>
    </div>
@endif
