<h1 align="center">CITY PARKING</h1>

## Seminarski rad - Programer internet aplikacija (PHP & MySQL)
- RAD: Aplikacija za uređena parkirališta + Parking simulator
- POLAZNIK: Hrvoje Sirić
- UČILIŠTE: Algebra

## Opis seminarskog rada
APLIKACIJA ZA UREĐENA PARKIRALIŠTA (uređena parkirališta podrazumjevaju da imaju ulazne i izlazne rampe, uređaj za plaćanje)

Korisnici imaju mogućnost:
 - rezervirati mjesto na parkingu
 - vidjeti trenutačno stanje na parkingu (broj zauzetih mjesta / broj rezerviranih mjesta / ukupan broj mjesta)

    ###### REZERVIRANJE PARKIRNOG MJESTA
    Dok pregledavaju stanje na parkiralištima koja podržavaju ovu aplikaciju korisnici imaju mogućnost rezervirati mjesto.

    Rezervacija mjesta:
      - se naplaćuje (cijena ovisi o parkingu)
      - korisnik nakon zahtjeva dobiva četveroznamenkasti KOD kojeg validira na ulazu u parking (ulazne rampe imaju jednostavnu tipkovnicu i display)
      - korisnik ima određeno vrijeme da validira dobiveni KOD na izabranom parkiralištu (cca 20-30min - u protivnom mu se obračunava dodatna naknada za neispunjavanje rezervacije (DA SE ZAUSTAVI ISKORIŠTAVANJE MASOVNIH REZERVACIJA))
      - korisnik ima određeno vrijeme za otkazati rezervaciju (cca 5-10 min - rezervacija mu se naplaćuje tek kada ovo vrijeme istekne (NEMA SMISLA NAPLATITI REZERVACIJU KOJA JE OTKAZANA NA VRIJEME - USER FRIENDLY))
        nakon otkazivanja korisniku se na neko kratko vrijeme onemogućava rezervacija ( cca 5 min - DA SE ZAUSTAVI ISKORIŠTAVANJE MASOVNIH OTKAZIVANJA REZERVACIJA)

      - na ulazu u prakiralište korisnik upisuje rezervacijski KOD i dobiva ulaznu kartu


PARKING SIMULATOR

Za potrebe testiranja ove aplikacije izradio sam simulator ulaska i izlaska vozila (i osoba) iz parkirališta

    VOZILA
        Rad u simulatoru koji se odnosi na ulaz i izlaz vozila (ulaz i izlaz, validacija KODA za ulaz, validacija karte za izlaz) je označen PLAVOM bojom
    OSOBE
        Rad u simulatoru koji se odnosi na kretanje osoba na parkiralištu (ulaz, plaćanje karte) je označen ZELENOM bojom

    RAD U SIMULATORU
        Na odabir parkirališta (grad, naziv) ulazimo u simulaciju tog odabranog parkirališta.
        Simulator ima 4 sekcije koje nam govore gdje se trenutačno nalazimo i korisnik se može kretati od jedne do druge ovisno o potrebi i situaciji:
        - ULAZNA RAMPA
        - PARKING
        - UREĐAJ ZA PLAĆANJE
        - IZLAZNA RAMPA

        Ako smo na ULAZNOJ RAMPI uzeli kartu i ušli u parkiralište rampa se nakon našeg ulaza zatvara (što znači da toj sekciji više ne možemo pristupiti s našim vozilom). Sekcija PARKING nam omogućava
        da vidimo stanje na parkiralištu 'golim okom' (ukupan broj mjesta, broj zauzetih mjesta, podatci o parkingu). Ako nakon nekog vremena odlučimo napustiti parkiralište s našim vozilom moramo otići
        na sekciju UREĐAJA ZA PLAĆANJE. Tamo plaćamo kartu i upućujemo se na sekciju IZLAZNE RAMPE gdje validiramo je li karta plaćena ili ne. Ako je plaćena možemo napustiti parkiralište a ako nije
        onda se moramo vratiti na sekciju UREĐAJA ZA PLAĆANJE i platiti kartu te pokušati ponovo izaći.

    OGRANIČENJA I KAZNE
        Ukoliko je osoba platila kartu ali se odlučila još zadržati na parkingu s vozilom (recimo da je netko platio kartu ali je otišao šetati po gradu jos 2 sata) na validaciji na IZLAZNOJ RAMPI
        validator će vidjeti da je prošlo više od 10 minuta koje osoba ima da napusti parking te će resetirati vrijeme karte na prošlo vrijeme plaćanje te će osoba trebati ponovo platiti kartu.

    KARTE I PLAĆANJA
        Napominjem da je ovo samo simulacija ... KARTU odnosno njeno fizičko postojanje zamjenjuje KOD od velikog niza znamenki (koji možete kopirati sa strane ili pogledati u bazu da ne zaboravite).
        Novac zamjenjuje jednostavan upis brojeva (ako upišete broj 7 znači da ste ubacili 7 kn).


## APLIKACIJA

- Laravel
- Centaur Sentinel
- Sluggable (za rute simulatora)
- Mailtrap (za testiranje mailova)
- logo u Adobe Illustratoru


## PROBLEMI I KODIRANJE

- nisam koristio mailgun jer sam imao nekakvih problema sa GUZZLE-om. Error:
    (GuzzleHttp\Exception\ClientException: Client error: `POST https://api.mailgun.net/v3/sandbox22f9hisujrundei134m9nf84.mailgun.org/messages.mime` resulted in a `400 BAD REQUEST` response:
    "message": "Sandbox subdomains are for test purposes only. Please add your own domain or add the address to authoriz (truncated...))

- pri izračunu za cijenu karte parkinga (koja obračunava cijenu samo u radnim satima) koristio sam veliki blok KODA sa puno IF izjava (znam da se tako ne radi ali eto nisam smislia ništa bolje trenutačno)

- SimulatorController mi je zapravo jedan veliki switch koji gleda koji je BUTTON u formi pritisnut (također znam da to može bolje ali sam stvarno htio da simulator bude na jednoj ruti
    (/simulator/zadar-fosa A NE NA /simulator/zadar-fosa/uredaj_za_placanje/forma_2/...)) ... ako postoji bolji način htio bi znati

- Brisanje rezervacija radim u contruct() metodi ... koja se pokreće svaki put kad bilo koja radnja ima veze s rezervacijama. Ona gleda sve rezervacije koje su istekle te ih briše. Ne znam je li
 ovo baš ispravan način ili se može napraviti da se brišu direktno u bazi kad vrijeme istekne?


## NAPOMENA

- U SentinelDatabaseSeeder.php datoteci sam izbrisao jednu liniju KODA (označeno komentarom u datoteci)
