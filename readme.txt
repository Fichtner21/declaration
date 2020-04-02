=== Declaration ===
Contributors: Fichtner21, Interakcjo
Donate link: https://github.com/Fichtner21/declaration
Tags: comments, spam
Requires at least: 3.0
Tested up to: 5.4
Stable tag: 5.4
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Wtyczka tworząca stronę deklaracji dostępności

== Description ==

Warunki techniczne publikacji oraz struktura dokumentu elektronicznego "Deklaracji Dostępności"
Na podstawie art. 12 pkt 7 ustawy z dnia 4 kwietnia 2019 r. o dostępności cyfrowej stron internetowych i aplikacji mobilnych podmiotów publicznych (Dz. U. poz. 848), dalej zwanej „ustawą o dostępności cyfrowej”, niniejszy dokument określa warunki techniczne publikacji Deklaracji Dostępności oraz strukturę dokumentu elektronicznego Deklaracji Dostępności..

Ustawa o dostępności cyfrowej zobowiązuje w art. 10 podmioty publiczne do sporządzania i publikowania Deklaracji Dostępności. Celem publikacji Deklaracji Dostępności jest umożliwienie zapoznania się z informacjami dotyczącymi dostępności podmiotu publicznego. Informacje te przydadzą się przede wszystkim osobom z niepełnosprawnościami, które będą dzięki temu wiedzieć, jakie pomoce czy rozwiązania wspierające są dostępne w odniesieniu do danego podmiotu.

Warunki techniczne odnoszą się zarówno do Deklaracji Dostępności strony internetowej, jak i Deklaracji Dostępności aplikacji mobilnej. Używane pojęcie „strona internetowa” należy w przypadku aplikacji mobilnej  zamieniać na „aplikacja mobilna”. Różnice pomiędzy Deklaracjami Dostępności strony internetowej i aplikacji mobilnej są opisane w treści wymagań technicznych.

Deklaracja dostępności jest przygotowana w formacie HTML, w jego dowolnej wersji.

Deklaracja dostępności spełnia wymagania zawarte w art. 5 ustawy o dostępności cyfrowej, nawet jeżeli sama strona internetowa lub aplikacja mobilna ich nie spełnia. Oznacza to, że Deklaracja Dostępności musi być w pełni dostępna cyfrowo.

# Link do deklaracji dostępności

Link do Deklaracji Dostępności powinien być łatwy do odnalezienia na stronie głównej, wczytywanej jako pierwsza po wpisaniu adresu strony internetowej lub w miejscu zawsze wyświetlanym na wszystkich podstronach strony internetowej na przykład w stopce lub nagłówku. Dobrą praktyką jest umieszczenie w nagłówku wszystkich podstron strony internetowej metatagu zawierającego link do Deklaracji Dostępności, według poniższego wzoru:

<meta name=”deklaracja-dostępności” content=”http://xn--xxxx-jb7a”>

gdzie xxxx jest adresem internetowym Deklaracji Dostępności strony internetowej.

# W Deklaracji stosowane są poniższe identyfikatory:

* a11y-deklaracja: Nagłówek poziomu 1 z tytułem dokumentu „Deklaracja dostępności” – przykład:
* <h2 id=”a11y-deklaracja”>Deklaracja dostępności</h2>;
* a11y-wstep: obowiązkowe oświadczenie o dostępności;
* a11y-podmiot: nazwa podmiotu publicznego;
* a11y-url: adres strony internetowej lub aplikacji mobilnej do pobrania;
* a11y-data-publikacja: data opublikowania strony internetowej lub wydania aplikacji;
* a11y-data-aktualizacja: data ostatniej aktualizacji strony internetowej lub aplikacji mobilnej;
* a11y-status: status pod względem zgodności z ustawą o dostępności cyfrowej;
* a11y-ocena: link do dokumentu z analizą o nadmiernym obciążeniu. Identyfikator jest opcjonalny;
* a11y-data-sporzadzenie: data sporządzenia Deklaracji Dostępności;
* a11y-audytor: nazwa podmiotu zewnętrznego, który przeprowadził badanie dostępności. Identyfikator jest opcjonalny;
* a11y-kontakt: sekcja z danymi kontaktowymi;
* a11y-osoba: imię i nazwisko osoby odpowiedzialnej za kontakt w sprawie niedostępności (osoba kontaktowa);
* a11y-email: adres poczty elektronicznej osoby kontaktowej – przykład:
* <a id=”a11y-email” href=”mailto: dostepnosc@podmiot-publiczny.pl”>dostepnosc@podmiot-publiczny.pl</a>;
* a11y-telefon: numer telefonu do osoby kontaktowej;
* a11y-procedura: opis procedury wnioskowo-skargowej;
* a11y-architektura: sekcja z informacjami o dostępności architektonicznej.
* a11y-aplikacje: sekcja z informacjami o aplikacjach.

== Installation ==

Aktywowanie wtyczki tworzy automatycznie stronę z deklaracją dostępności pod adresem "ADRES_TWOJEJ_STRONY/deklaracja-dostepnosci/".
W celu uzupełnienia brakujących treści należy edytować stronę Deklaracji Dostępności, która znajduje się kokpicie WordPressa w zakładce "Strony > Deklaracja Dostępności (edytuj)".

== Changelog ==