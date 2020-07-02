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
        <label for="update-date" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-calendar-alt"></span>Data ostatniej istotnej aktualizacji (Format: RRRR-MM-DD):</h3></label>
        <input type="text" id="update-date" name="update-date" class="declaration-meta-form__input" value="<?= $update_date[0]; ?>">
    </div>

    <div class="declaration-meta-form__row">
        <h3><span class="dashicons dashicons-visibility"></span> Status pod względem zgodności z ustawą</h3>
        <label for='status-zgodna'><input type="radio" name="status" id="status-zgodna" value='zgodna' <?= $status[0] == 'zgodna' || $status[0] == ' ' ? 'checked' : false; ?>>Zgodna</label>
        <label for='status-czesciowo-zgodna'><input type="radio" name="status" value='czesciowo-zgodna' id="status-czesciowo-zgodna" <?= $status[0] == 'czesciowo-zgodna' ? 'checked' : false; ?>>Częściowo zgodna</label>
        <label for='status-neizgodna'><input type="radio" name="status" value='niezgodna' id="status-neizgodna" <?= $status[0] == 'niezgodna' ? 'checked' : false; ?>>Niezgodna</label>

        <?php if($status[0] == 'zgodna' || $status[0] == ' ') : ?>
            <!-- nothing to do -->
        <?php elseif($status[0] == 'czesciowo-zgodna') : ?>
            <div class="declaration-meta-form__row">
                <label for="status_field_1" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-visibility"></span> Wymagania niespełnione</h3></label>
                <?= wp_editor($status_field_1[0], "status_field_1", array('editor_height' => 100, 'quicktags' => false)); ?>
            </div>

            <div class="declaration-meta-form__row">
                <label for="status_field_2" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-visibility"></span> Wyłączenia</h3></label>
                <?= wp_editor($status_field_2[0], "status_field_2", array('editor_height' => 100, 'quicktags' => false)); ?>
            </div>
        <?php else : ?>
            <div class="declaration-meta-form__row">
                <label for="status_field_3" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-visibility"></span> Wymagania niespełnione</h3></label>
                <?= wp_editor($status_field_3[0], "status_field_3", array('editor_height' => 100, 'quicktags' => false)); ?>
            </div>

            <div class="declaration-meta-form__row">
                <label for="status_field_4" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-visibility"></span> Wyłączenia</h3></label>
                <?= wp_editor($status_field_4[0], "status_field_4", array('editor_height' => 100, 'quicktags' => false)); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="rating" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-admin-links"></span> Wynik analizy obciążenia <span style="font-size: 10px;">(opcjonalne)</span></h3></label>
        <label for='rating_on'><input type="checkbox" name="rating_on" id="rating_on" <?= $rating_on[0] == 'on' ? 'checked' : false; ?>> Zaznacz jeśli chcesz podać wynik analizy obciążenia</label>
        <?php if($rating_on[0] == 'on') : ?>
            <p style='margin-bottom: 7px;'>Podaj link to wyniku analizy:</p>
            <input type="text" id="rating" name="rating" class="declaration-meta-form__input" value="<?= $rating[0]; ?>">
        <?php endif; ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="attention-optional" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-media-document"></span> Uwagi: <span style="font-size: 10px;">(opcjonalne)</span></h3></label>
        <?= wp_editor($attention_optional[0], "attention-optional", array('editor_height' => 100, 'quicktags' => false)); ?>
    </div>

     <div class="declaration-meta-form__row">
        <label for="page-date" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-calendar"></span> Data sporządzenia oświadczenia o deklaracji dostępności (Format: RRRR-MM-DD):</h3></label>
        <input type="text" id="page-date" name="page-date" class="declaration-meta-form__input" value="<?= $page_date[0]; ?>">
    </div>

    <div class="declaration-meta-form__row">
        <label for="address-email" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-email-alt"></span> Adres poczty elektronicznej osoby kontaktowej</h3></label>
        <input type="email" id="address-email" name="address-email" class="declaration-meta-form__input" value="<?= $address_email[0]; ?>">
    </div>

    <div class="declaration-meta-form__row">
        <label for="phone-number" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-phone"></span> Numer telefonu do osoby kontaktowej</h3></label>
        <?= wp_editor($phone_number[0], "phone-number", array('editor_height' => 100, 'media_buttons' => false, 'quicktags' => false )); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-1" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostępności wejścia do budynku i przechodzenia przez obszary kontrolii</h3></label>
        <?= wp_editor($accessibility_1[0], "accessibility-1", array('editor_height' => 200, 'quicktags' => false )); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-2" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostępności korytarzy, schodów i wind</h3></label>
        <?= wp_editor($accessibility_2[0], "accessibility-2", array('editor_height' => 200, 'quicktags' => false)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-3" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostosowań, na przykład pochylni, platform, informacji głosowych, pętlach indukcyjnych</h3></label>
        <?= wp_editor($accessibility_3[0], "accessibility-3", array('editor_height' => 200, 'quicktags' => false)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-4" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Informacje o miejscu i sposobie korzystania z miejsc parkingowych wyznaczonych dla osób niepełnosprawnych</h3></label>
        <?= wp_editor($accessibility_4[0], "accessibility-4", array('editor_height' => 200, 'quicktags' => false)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-5" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-buddicons-activity"></span> Informacja o prawie wstępu z psem asystującym i ewentualnych uzasadnionych ograniczeniach</h3></label>
        <?= wp_editor($accessibility_5[0], "accessibility-5", array('editor_height' => 200, 'quicktags' => false)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="accessibility-6" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-universal-access"></span> Informacje o możliwości skorzystania z tłumacza języka migowego na miejscu lub online. W przypadku braku takiej możliwości, taką informację także należy zawrzeć</h3></label>
        <?= wp_editor($accessibility_6[0], "accessibility-6", array('editor_height' => 200, 'quicktags' => false)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="mobile-app-android" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-smartphone"></span> (Android) Wymienić aplikacje oraz informację skąd można je pobrać</h3></label>
        <?= wp_editor($mobile_app_android[0], "mobile-app-android", array('editor_height' => 100, 'quicktags' => false)); ?>
    </div>

    <div class="declaration-meta-form__row">
        <label for="mobile-app-ios" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-smartphone"></span> (iOS) Wymienić aplikacje oraz informację skąd można je pobrać</h3></label>
        <?= wp_editor($mobile_app_ios[0], "mobile-app-ios", array('editor_height' => 100, 'quicktags' => false)); ?>
    </div>
</div>

<script>

(function($) {
    $(document).ready(function() {
       const $statusInputs = $('input[name="status"]');
       const $form = $('form[name="post"]');

       $.each($statusInputs, function (index, input) {
            $(input).on('change', function() {
                if($(this).val() === 'zgodna') {
                    $form.submit();
                } else {
                    alert('Po odświeżeniu pojawią się dwa nowe pola status. Proszę je uzupełnić.');

                    $form.submit();
                }
            });
       });

       const $ratingCheckbox = $('input[name="rating_on"]');

       $ratingCheckbox.on('change', function() {
        if($(this).val() === 'on') {
            alert('Po odświeżeniu pojawi się nowe pole do podania linku. Proszę je uzupełnić.');

            $form.submit();
        } else {
            alert('Po odświeżeniu zniknie pole z linkiem.');

            $form.submit();
        }
       });
    });
})(jQuery);

</script>