<div class="declaration-meta-form">        
    <div class="declaration-meta-form__row">
        <label for="fullname" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-admin-users"></span> Imię i nazwisko osoby odpowiedzialnej za kontakt w sprawie niedostępności</h3></label>
        <input type="text" id="fullname" name="fullname" class="declaration-meta-form__input" value="<?= $fullname[0]; ?>">
    </div>

    <div class="declaration-meta-form__row">
        <label for="publish-date" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-calendar-alt"></span> Data publikacji strony internetowej (Format: RRRR-MM-DD):</h3></label>
        <input type="text" id="publish-date" name="publish-date" class="declaration-meta-form__input" value="<?= $publish_date[0]; ?>">
    </div>

    <div class="declaration-meta-form__row">
        <label for="address-email" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-email-alt"></span> Adres poczty elektronicznej osoby kontaktowej</h3></label>
        <input type="email" id="address-email" name="address-email" class="declaration-meta-form__input" value="<?= $address_email[0]; ?>">
    </div>

    <div class="declaration-meta-form__row">
        <label for="phone-number" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-phone"></span> Numer telefonu do osoby kontaktowej</h3></label>
        <?= wp_editor($phone_number[0], "phone-number", array('editor_height' => 100, 'media_buttons' => false )); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-1" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostępności wejścia do budynku i przechodzenia przez obszary kontrolii</h3></label>
        <?= wp_editor($accessibility_1[0], "accessibility-1", array('editor_height' => 200)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-2" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostępności korytarzy, schodów i wind</h3></label>
        <?= wp_editor($accessibility_2[0], "accessibility-2", array('editor_height' => 200)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-3" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostosowań, na przykład pochylni, platform, informacji głosowych, pętlach indukcyjnych</h3></label>
        <?= wp_editor($accessibility_3[0], "accessibility-3", array('editor_height' => 200)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-4" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Informacje o miejscu i sposobie korzystania z miejsc parkingowych wyznaczonych dla osób niepełnosprawnych</h3></label>
        <?= wp_editor($accessibility_4[0], "accessibility-4", array('editor_height' => 200)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-5" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-buddicons-activity"></span> Informacja o prawie wstępu z psem asystującym i ewentualnych uzasadnionych ograniczeniach</h3></label>
        <?= wp_editor($accessibility_5[0], "accessibility-5", array('editor_height' => 200)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-6" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-universal-access"></span> Informacje o możliwości skorzystania z tłumacza języka migowego na miejscu lub online. W przypadku braku takiej możliwości, taką informację także należy zawrzeć</h3></label>
        <?= wp_editor($accessibility_6[0], "accessibility-6", array('editor_height' => 200)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="mobile-app-android" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-smartphone"></span> (Android) Wymienić aplikacje oraz informację skąd można je pobrać</h3></label>
        <?= wp_editor($mobile_app_android[0], "mobile-app-android", array('editor_height' => 100)); ?>
    </div>        

    <div class="declaration-meta-form__row">
        <label for="mobile-app-ios" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-smartphone"></span> (iOS) Wymienić aplikacje oraz informację skąd można je pobrać</h3></label>
        <?= wp_editor($mobile_app_ios[0], "mobile-app-ios", array('editor_height' => 100)); ?>
    </div>
</div>