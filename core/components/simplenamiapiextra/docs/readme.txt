Extra: simpleNaMiAPIExtra
=========================

Ein Extra, das simpleNaMiAPI in MODX integriert. Mehr zu simpleNaMiAPI unter:
https://github.com/Florian1990/simpleNaMiAPI

Funktionsumfang
---------------

simpleNaMiAPIExtra stellt zwei Schnittstellen zur Verfügung:

1. Die Klasse modNamiWrapper
2. Das Snippet getNamiWrapper

Die Klasse modNamiWrapper erweiter NamiWrapper. Die Dokumentation zu NamiWrapper
ist an folgender Stelle zu finden:
https://github.com/Florian1990/simpleNaMiAPI#funktionsumfang

modNamiWrapper unterscheidet sich von NamiWrapper folgendermaßen:

* Alle Funktionen, die Exceptions werfen wurden überschrieben, um diese in MODX
  zu loggen.
* Der Konstruktor hat folgende Signatur:
  public function __construct($modx, $config = null)
  $modx erwartet dabei das modX-Objekt, $config ggf. einen Array, der an den
  Eltern-Konstruktor übergeben wird. (Mehr zu $config in der Dokumentation zu
  simpleNaMiAPI.)

getNamiWrapper ist dafür gedacht, ein modNamiWrapper-Ojekt bereitzustellen.
Dieses Snippet ruft $modx->getService() auf um ein Objekt der Klasse
modNamiWrapper bereitzustellen.

Folgende Parameter können an das Snippet übergeben werden:

&name string Optional. Standardwert: 'modNamiWrapper'. Der Name, unter dem das
    erstellte Objekt für nachfolgend ausgeführte Snippets zur Verfügung steht.
&config array Optional. Standardwert: `[]`. Das Konfigurations-Array, das an
    den Konstruktor von modNamiWrapper übergeben wird.
&iniFile string|null Optional. Standardwert: null. Falls &iniFile ungleich null
    bzw. '' ist, wird $config['iniFile'] auf den übergebenen Wert gesetzt.
    Relative Pfadangaben sind relativ zu
    {core_path}components/simplenamiapiextra/model/simplenamiapi/
&saveCookieInFile boolean|null Optional. Standardwert: null. Falls
    &saveCookieInFile ungleich null bzw. '' ist, wird
    $config['saveCookieInFile'] auf den übergebenen Wert gesetzt.
&saveCookieInSession boolean Optional. Standardwert: false. Falls
    &saveCookieInSession true ist, wird der Inhalt des NaMi-Cookies in
    $_SESSION['simpleNaMiAPIExtra.' . &name] gespeichert.

Beispiel 1: Snippet in Ressource einbinden

Wenn Sie in einer Ressource [[!getNamiWrapper? &name=`meinWrapper`]] einbinden,
können alle nachfolgend ausgefürhten Snippets mittels $nw =
$modx->getService('meinWrapper') auf das erstellte Objekt zugreifen.

Beispiel 2: Snippet in Snippet etc. einbinden

Wesentlich komfortabler ist der Aufruf von getNamiWrapper direkt in einem
Snippet, Plugin etc.:

$nw = $modx->runSnippet('getNamiWrapper', ['saveCookieInFile' => true]);
$nw2 = $modx->runSnippet('getNamiWrapper', ['name' => 'meinNamiWrapper',
    'saveCookieInSession' => true, 'iniFile' => 'special.ini']);

Werden verschiedene Instanzen von modNamiWrapper benötigt, ist darauf zu achten,
dass sie mit verschiedenen name-Parametern aufgerufen werden, da
$modx->getService() sonst beim zweiten Aufruf keine neue Instanz anfertigt,
sondern die erste zurückgibt.