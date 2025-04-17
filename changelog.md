# INTEGRUM Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Satel Versioning](ver) .

Zalecane przeglądarki (wersje na których wykonano testy oprogramowania):
EDGE 79 (79.0.382)
Firefox 49 (49.0.1)
Chrome 53 (59.0.2785.143 m)
Safari 9  (9.1.2)

### [02.0.7] - 2020-05-25
Wersje komponentów INTEGRUM: Web 2.0.7, Server 2.0.6, AppServer 2.0.7, DB 2.0.6
 * dodanie opcji kasowania zdarzeń użytkowników z poziomu interfejsu - RODO: prawo do bycia zapomnianym 

### [02.0.6] - 2020-02-25
Wersje komponentów INTEGRUM: Web 2.0.6, Server 2.0.6, AppServer 2.0.6, DB 2.0.6
 * obsługa archiwizacji zdarzeń z poziomu interfejsu
 * adaptacyjne wyznaczanie czasu oczekiwania na odpowiedź centrali
   (poprawa stabliności połączenia w sieciach o dużych opóźnieniach)  
 * możliwość przełączenia działania filtru czuwania na liście central na "nie czuwa"

### [02.0.5] - 2020-01-20
Wersje komponentów INTEGRUM: Web 2.0.3, Server 2.0.5, AppServer 2.0.3, DB 2.0.5
 * poprawka w wyświetlaniu stref użytkowników dla Integra 256 PLUS (reedycja)
 * lepsza obsługa komunikatów podczas kasowania hierarchii
 * dodano wsparcie dla ETHM-1 Plus w wersji 2.06
 * poprawiono odświeżanie stanu stref i wejść po ponownym połączeniu
 * poprawiono utrzymanie sieci na widoku Panelu sterowania
 * poprawiono wznawianie połączenia z centralą poprzez przełącznik "Aktywna"

### [02.0.3] - 2018-10-30
Wersje komponentów INTEGRUM: Web 2.0.3, Server 2.0.2, AppServer 2.0.3, DB 2.0.3
 * dodane ekspandery i manipulatory w szczegółach zdarzeń Kontrola dostępu
 * poprawa stanu centrali na mapie przy pełnym czuwaniu/braku połączenia
 * dodany szraf przy częściowy czuwaniu, pamięci alarmu/awarii
 * poprawa eksportu Zdarzeń
 * aktualizacja MapEditor

### [02.0.2] - 2018-10-10
Wersje komponentów INTEGRUM: Web 2.0.2, Server 2.0.2, AppServer 2.0.2, DB 2.0.3
 * zmiana sposobu przechowywania geometrii tekstów na mapie
 * poprawki w edycji ról przypisanych użytkownikowi

### [02.0.2] - 2018-09-20
Wersje komponentów INTEGRUM: Web 2.0.2, Server 2.0.2, AppServer 2.0.2, DB 2.0.2
 * obsługa przejść na mapie i w szczegółach Centrali
 * obsługa wyjść w szczegółach centrali
 * kompatybilność z MapEditor 3.1

### [02.0.1] - 2018-09-04
Wersje komponentów INTEGRUM: Web 2.0.1, Server 2.0.1, AppServer 2.0.1, DB 2.0.1
 * obsługa połączeń nawiązywanych przez centralę

### [02.0.0] - 2018-08-23
Wersje komponentów INTEGRUM: Web 2.0.0, Server 2.0.0, AppServer 2.0.0, DB 2.0.1
 * możliwość przypisania wielu regionów do użytkownika
 * aktualizacja komponentów systemowych WILDFLY (do wersji 12) i PHP (do wersji 7.0)
 * MapEditor 3.0 uproszczony interfejs, możliwość wstawiania opisów, grupowe dodawanie obiektów