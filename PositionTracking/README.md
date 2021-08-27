# PositionTracking
Erlaubt das Tracken z.B. von Fahrzeugen auf einer interaktiven Google Maps Karte

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Diese Modul zeigt eine Position aus je einer Breitengrad/Längengrad Variable auf einer Google Maps Karte an. Der Positions-Tracker aktualisiert dabei fortlaufend und automatisch, sodass z.B. ein Auto oder anderes Objekt interaktiv auf der Karte verfolgt werden kann. Dieses Modul wird am besten mit dem 'NMEA GPS' Modul kombiniert, welches laufend aktuelle GPS Daten empfängt. Für dieses Modul ist ein Google Maps API Key erforderlich, der bei massiver Benutzung Kosten verursachen kann. Für einen normalen Betrieb reicht das von Google bereitgestellte kostenlose Kontingent normalerweise vollkommen aus.    

### 2. Vorraussetzungen

- IP-Symcon ab Version 5.5
- Google Maps API Key: https://developers.google.com/maps/documentation/javascript/get-api-key

### 3. Software-Installation

* Über den Module Store das 'PositionTracking'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen: https://github.com/paresy/PositionTracking

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'PositionTracking'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Name               | Beschreibung
------------------ | ------------------
Breitengrad        | Variable, welche die Breitengrad Angabe enthält
Längengrad         | Variable, welche die Längengrad Angabe enthält
Updatelimitierung  | Maximales Updateintervall in Sekunden (Das GPS sendet normalerweise jede Sekunden - um Traffic zu sparen empfiehlt es sich diesen Wert höher zu stellen, sodass die Position auf der Karte nur alle X Sekunden aktualisiert wird)
Karte (Breite)     | Breite der Karte in px oder %
Karte (Höhe)       | Höhe der Karte in px oder %
Icon (Home)        | Icon (PNG, JPEG) für den Standort, der im Location Control hinterlegt ist
Icon (Tracker)     | Icon (PNG, JPEG) für das sich bewegende Objekt

### 5. Statusvariablen und Profile

Die Map Variable ist eine HTMLBox, welche die Google Maps Karte beinhaltet und den Tracker anzeigt.

### 6. WebFront

Die Map wird als Karte direkt im WebFront dargestellt

### 7. PHP-Befehlsreferenz

Keine Funktionen verfügbar
