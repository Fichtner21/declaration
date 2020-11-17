<?php

/**
* Template Name: Declaration
*/

get_header();

?>

<?php
    global $post;

    $custom = get_post_custom($post->ID);

    $fullname = isset($custom["fullname"][0]) ? $custom["fullname"] : " ";
    $address_email = isset($custom["address-email"][0]) ? $custom["address-email"] : " ";
    $publish_date = isset($custom["publish-date"][0]) ? $custom["publish-date"] : " ";
    $page_date = isset($custom["page-date"][0]) ? $custom["page-date"] : " ";
    $attention_optional = isset($custom["attention-optional"][0]) ? $custom["attention-optional"] : " ";
    $phone_number = isset($custom["phone-number"][0]) ? $custom["phone-number"] : " ";
    $update_date = isset($custom["update-date"][0]) ? $custom["update-date"] : " ";
    $status = isset($custom["status"][0]) ? $custom["status"] : " ";
    $rating_on = isset($custom["rating_on"][0]) ? $custom["rating_on"] : " ";
    $rating = isset($custom["rating"][0]) ? $custom["rating"] : " ";

    $status_field_1 = isset($custom["status_field_1"][0]) ? $custom["status_field_1"] : " ";
    $status_field_2 = isset($custom["status_field_2"][0]) ? $custom["status_field_2"] : " ";
    $status_field_3 = isset($custom["status_field_3"][0]) ? $custom["status_field_3"] : " ";
    $status_field_4 = isset($custom["status_field_4"][0]) ? $custom["status_field_4"] : " ";

    $accessibility_1 = isset($custom["accessibility-1"][0]) ? $custom["accessibility-1"] : " ";
    $accessibility_2 = isset($custom["accessibility-2"][0]) ? $custom["accessibility-2"] : " ";
    $accessibility_3 = isset($custom["accessibility-3"][0]) ? $custom["accessibility-3"] : " ";
    $accessibility_4 = isset($custom["accessibility-4"][0]) ? $custom["accessibility-4"] : " ";
    $accessibility_5 = isset($custom["accessibility-5"][0]) ? $custom["accessibility-5"] : " ";
    $accessibility_6 = isset($custom["accessibility-6"][0]) ? $custom["accessibility-6"] : " ";

    $mobile_app_android = isset($custom["mobile-app-android"][0]) ? $custom["mobile-app-android"] : " ";
    $mobile_app_ios = isset($custom["mobile-app-ios"][0]) ? $custom["mobile-app-ios"] : " ";
    $editor_dec = isset($custom["dec_test"][0]) ? $custom["dec_test"] : " ";

?>

<main id="site-content" role="main" style="padding: 30px 0;">
    <div class="custom-container">
        <?php
        $args_old = array(
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'ASC',
            'post_type'        => array('post', 'page'),
            'post_status'      => 'publish'
        );

        $posts_array_oldest = get_posts($args_old);

        $args_new = array(
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => array('post', 'page'),
            'post_status'      => 'publish'
        );

        $posts_array_newest = get_posts($args_new);
        ?>

        <h2 id=”a11y-deklaracja” class='add-margin'><?php the_title(); ?></h2>
        <div id="a11y-wstep" class='add-margin'><span id="a11y-podmiot"><?php echo get_bloginfo('name'); ?></span> zobowiązuje się zapewnić dostępność swojej strony internetowej zgodnie z ustawą z dnia 4 kwietnia 2019 r. o dostępności cyfrowej stron internetowych i aplikacji mobilnych podmiotów publicznych. Oświadczenie w sprawie dostępności ma zastosowanie do <a href="<?php echo get_home_url(); ?>" id="a11y-url">strony internetowej <?php echo get_bloginfo('name'); ?></a>.</div>

        <p class='add-margin'>Data publikacji strony internetowej: <span id="a11y-data-publikacja"><?= $date_exist = ($publish_date[0] == true) ? $publish_date[0] : get_the_date('Y-m-d', $posts_array_oldest[0]); ?></span>. Data ostatniej istotnej aktualizacji: <span id="a11y-data-aktualizacja"><?php echo $update_date[0]; ?></span>.</p>

        <?php if($status[0] == 'zgodna' || $status[0] == ' ') : ?>
            <div id="a11y-status" class='add-margin'>Strona internetowa jest zgodna z ustawą z dnia 4 kwietnia 2019 r. o dostępności cyfrowej stron internetowych i aplikacji mobilnych podmiotów publicznych z powodu niezgodności lub wyłączeń wymienionych poniżej:</div>
        <?php elseif($status[0] == 'czesciowo-zgodna') : ?>
            <div id="a11y-status" class='add-margin'>Strona internetowa jest częściowo zgodna z ustawą z dnia 4 kwietnia 2019 r. o dostępności cyfrowej stron internetowych i aplikacji mobilnych podmiotów publicznych z powodu niezgodności lub wyłączeń wymienionych poniżej:
                <div class='add-margin'>
                    <?= wpautop(stripslashes($status_field_1[0])); ?>
                </div>

                <div class='add-margin'>
                    Wyłączenia:
                    <?= wpautop(stripslashes($status_field_2[0])); ?>
                </div>
            </div>
        <?php else : ?>
            <div id="a11y-status" class='add-margin'>Strona internetowa jest częściowo zgodna z ustawą z dnia 4 kwietnia 2019 r. o dostępności cyfrowej stron internetowych i aplikacji mobilnych podmiotów publicznych z powodu niezgodności lub wyłączeń wymienionych poniżej:
                <div class='add-margin'>
                    <?= wpautop(stripslashes($status_field_3[0])); ?>
                </div>

                <div class='add-margin'>
                    Wyłączenia:
                    <?= wpautop(stripslashes($status_field_4[0])); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($rating_on[0] == 'on') : ?>
        <div id="a11y-ocena" class='add-margin'>
            <a href='<?= $rating[0]; ?>' title='Link do wyniku analizy nadmiernego obciążenia'>Link do wyniku analizy nadmiernego obciążenia</a>
        </div>
        <?php endif; ?>

        <div class='add-margin'><?= $attention_optional[0]; ?></div>
        <p class='add-margin'>Oświadczenie sporządzono dnia: <span id="a11y-data-sporzadzenie"><?= $page_date[0]; ?></span>. Deklarację sporządzono na podstawie samooceny przeprowadzonej przez podmiot publiczny.</p>

        <h3 id="a11y-kontakt" class='add-margin'>Informacje zwrotne i dane kontaktowe</h3>
        <p class='add-margin'>W przypadku problemów z dostępnością strony internetowej prosimy o kontakt. Osobą kontaktową jest  <span id="a11y-osoba"><strong><?= $fullname[0]; ?></strong></span>, <span id="a11y-email"><strong><?= $address_email[0]; ?></strong></span>. Kontaktować można się także dzwoniąc na numer telefonu <span id="a11y-telefon"><strong><?= $phone_number[0]; ?></strong></span>. Tą samą drogą można składać wnioski o udostępnienie informacji niedostępnej oraz składać żądania zapewnienia dostępności.</p>
        <p id="a11y-procedura" class='add-margin'> Każdy ma prawo do wystąpienia z żądaniem zapewnienia dostępności cyfrowej strony internetowej, aplikacji mobilnej lub jakiegoś ich elementu. Można także zażądać udostępnienia informacji za pomocą alternatywnego sposobu dostępu, na przykład przez odczytanie niedostępnego cyfrowo dokumentu, opisanie zawartości filmu bez audiodeskrypcji itp. Żądanie powinno zawierać dane osoby zgłaszającej żądanie, wskazanie, o którą stronę internetową lub aplikację mobilną chodzi oraz sposób kontaktu. Jeżeli osoba żądająca zgłasza potrzebę otrzymania informacji za pomocą alternatywnego sposobu dostępu, powinna także określić dogodny dla niej sposób przedstawienia tej informacji. Podmiot publiczny powinien zrealizować żądanie niezwłocznie, nie później niż w ciągu 7 dni od dnia wystąpienia z żądaniem. Jeżeli dotrzymanie tego terminu nie jest możliwe, podmiot publiczny niezwłocznie informuje o tym wnoszącego żądanie, kiedy realizacja żądania będzie możliwa, przy czym termin ten nie może być dłuższy niż 2 miesiące od dnia wystąpienia z żądaniem. Jeżeli zapewnienie dostępności cyfrowej nie jest możliwe, podmiot publiczny może zaproponować alternatywny sposób dostępu do informacji. W przypadku, gdy podmiot publiczny odmówi realizacji żądania zapewnienia dostępności lub alternatywnego sposobu dostępu do informacji, wnoszący żądanie możne złożyć skargę w sprawie zapewniana dostępności cyfrowej strony internetowej, aplikacji mobilnej lub elementu strony internetowej, lub aplikacji mobilnej. Po wyczerpaniu wskazanej wyżej procedury można także złożyć wniosek do Rzecznika Praw Obywatelskich.</p>
        <p>Link do strony internetowej <a href="https://www.rpo.gov.pl/" target="_blank">Rzecznika Praw Obywatelskich</a>.</p>

        <h3 id="a11y-atchitektura" class='add-margin'>Dostępność architektoniczna</h3>
        <ol class='add-margin'>
            <li><?= $accessibility_1[0]; ?></li>
            <li><?= $accessibility_2[0]; ?></li>
            <li><?= $accessibility_3[0]; ?></li>
            <li><?= $accessibility_4[0]; ?></li>
            <li><?= $accessibility_5[0]; ?></li>
            <li><?= $accessibility_6[0]; ?></li>
        </ol>

        <h3 id="a11y-aplikacje" class='add-margin'>Aplikacje mobilne</h3>
        <div class="mobile-app add-margin"><?= $mobile_app_android[0]; ?></div>
        <div class="mobile-app add-margin"><?= $mobile_app_ios[0]; ?></div>
    </div>
</main><!-- #site-content -->

<?php get_footer(); ?>