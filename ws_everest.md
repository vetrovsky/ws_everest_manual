# WS EVEREST Uživatelská příručka

## Obsah


## Způsob použití služby:

Služba bylo navržena pro potřeby partnerů (CK), které vyžadují kalkulaci z množiny dostupných pojistných produktů, uložení a odeslání návrhu pojistné smlouvy a příslušné dokumentace klientovi. Služba dále umožnuje aktivaci objednávky pojištění, zaslání interaktivního formuláře pro vyplnění storna služeb.

* Předběžnou kalkulaci ceny lze provést na základě vstupních údajů:
  - **Termínu**;
  - **identifikátorů pojištění/připojištění**; 
  - **Typu pojištění** (např. turistická cesta nebo rekreační sporty)
  - **Destinace** (konkrétní stát nebo riziková oblast). Pokud uživatel specifikuje stát, systém automaticky určí, zda tento stát patří do rizikové oblasti. Pokud je místo státu specifikována riziková oblast, rozhodnutí o zařazení do této oblasti závisí na uživateli.
  - **Rozsahu storna pojištění** (cena služeb/letenek).
  - **Typu prodeje** (prodej letenek nebo zájezdů).
  Pro tento typ dotazů se používá metoda **InsuranceOrder**.

* Vytvoření pojištění:
    Rozšířením metody **InsuranceOrder** o osobní údaje pojištěných osob:
    - **Jméno**,
    - **Příjmení**,
    - **Datum narození**,
    rozhraní umožní uživatelům vytvářet a ukládat záznamy do systému provozovatele TRAVEL SUPPORT SYSTEMS.
    Vložené objednávky se statusem **O** jsou vedeny jako neuhrazené a je nutné je aktivovat metodou **PaymentConfirmation**, následně exportovány jsou do pojišťovny. Naproti tomu, objednávky vložené se statusem **N** jsou vedeny jako uhrazené a jsou exportovány do pojišťovny bez nutnosti aktivace.

Pro uložené obchodního případy jsou v odpovědi vrácené URL dokumentů s příslušnou dokumentací ve formátu pdf. K zaslání dokumentů klientovi se používá metoda **SendEmail**. 
Dodatečně lze získat stav objednávky dokumentaci obchodního případu pomocí metody **InsuranceInfo**.

## Volání služby

1.	Pro použití služby je nutno získat UserKey, který obdržíte po registraci služby. Najdete jej také v Profilu uživatele > UserKey, v případě že používáte office systém Everest 2003. Tento se používá v requestech za účelem autorizace uživatele.  Pro vlastní testování používejte demo UserKey, který naleznete v testeru.
2.	WS umožnuje využívat XML nebo JSON syntaxi. Dotazy (requesty) zasílejte metodou POST v proměnné pojmenované xml pokud chcete využívat syntaxi XML. V případě, že budete chtít využívat formát JSON, POST proměnnou pojmenujte json. API rozhraní pro datovou komunikaci je dostupné na adrese:  https://ws.everest2003.cz/ws.php 

Příklad volání pomocí json:
  
```bash
  curl --request POST 'https://ws.everest2003.cz/ws.php' \
  -d "json={ \"OrderInfo\": { \"UserKey\": \"41059e28e30af11f62473ee29a93b2e1\", \"AccessKey\": \"06c66a36a4c9b52d6a34f8c833f74a7c\", \"ContractNo\": \"1445040\" } }"
```

volání v xml syntaxi:
```bash
  curl --request POST 'https://ws.everest2003.cz/ws.php' \
  -d "xml=<OrderInfo><UserKey>41059e28e30af11f62473ee29a93b2e1</UserKey><AccessKey>06c66a36a4c9b52d6a34f8c833f74a7c</AccessKey><ContractNo>1445040</ContractNo></OrderInfo>"
```

3. Názvy všech elementů jsou závislé na velikosti písmen (case sensitive). Číselné hodnoty v desetinném tvaru se zadávají s desetinnou tečkou (např. 1234.56). Všechny hodnoty musí být v uvozovkách. Kódování je UTF-8. 
4. Všechny metody v případě chyby nebo nesprávně zadaných budou vracet **ErrorResponse**. V případě úspěšného zpracování bude vrácen **Response** ve formátu, jak je popsáno v časti popis metod. Formát **ErrorResponse**:

| Jméno pole  | Popis pole    | Typ/délka znaků | Použití | Příklad hodnot          |
|-------------|---------------|-----------------|---------|-------------------------|
| ErrorNo     | Číslo chyby   | int             |         | 13                      |
| ErrorDesc   | Popis chyby   | char/255        |         | "Missing birth date"    |

5.	Interaktivní tester naleznete na https://ws.everest2003.cz/tester.php



## Typy pojištění a jejich obsah

Na základě smlouvy s pojišťovnou je provozovatelem zpřístupněné produkty dané pojišťovny. V současné době jsou dostupné tyto sady:

- UNIQA pojišťovna, a.s. 
- Generali Česká pojišťovna a.s. (GČP)
- INTER PARTNER ASSISTANCE S. A. (IPA)

### UNIQA pojišťovna, a.s.

- Označená sady **InsId**: 
  -  Y
- Typ prodeje **ticketing**:
  -  N
- Typ pojištění **InsType**:
  - t, zs
- Identifikátory pojištění **InsProduct**: 
  - K5, K5S, K10, K10S, K15, K15S, D5S, STS, K5A, K5SA, K5R, K10R, K15R
- Area
  - E,W

- Prodejní ceny a limity plnění jsou dostupné na stránkách (vyžaduje přihlášení):
  - https://www.everest2003.cz/modules.php?name=help

- Způsob zadávání produktů 

| Zkratka | InsProdukt | InsType | Poznámka                                           |
|---------|------------|---------|----------------------------------------------------|
| nD5S    | D5S        | t       | pouze ČR, turs, se stornem                         |
| nD5S+   | D5S        | zs      | pouze ČR, zimní, se stornem                        |
| nK5     | K5         | t       | Evropa/svět, turs, bez storna                      |
| nK5+    | K5         | zs      | Evropa/svět, zimní, bez storna                     |
| nK10    | K10        | t       | Evropa/svět, exclusiv turs, bez storna             |
| nK10+   | K10        | zs      | Evropa/svět, exclusiv zimní, bez storna            |
| nK15    | K15        | t       | Evropa/svět, exclusiv turs, bez storna             |
| nK15+   | K15        | zs      | Evropa/svět, exclusiv zimní, bez storna            |

  
### Individuální sazby UNIQA pojišťovna, a.s. 

- Označená sady **InsId**: 
  -  Y
- Typ prodeje **ticketing**:
  -  N
- Typ pojištění **InsType**:
  - t, zs
- Area
  - E,W

- Prodejní ceny a limity plnění jsou dostupné na stránkách (vyžaduje přihlášení):
  - https://www.everest2003.cz/modules.php?name=help

- Způsob zadávání produktů 

| Zkratka | InsProdukt | InsType | Poznámka                                           |
|---------|------------|---------|----------------------------------------------------|
| nD5S    | D5S        | t       | pouze pro ČR, turs, se stornem                    |
| nD5S+   | D5S        | zs      | pouze pro ČR, zimní, se stornem                   |
| nIK5    | IK5        | t       | Evropa/svět, turs, bez storna, individuál         |
| nIK5+   | IK5        | zs      | Evropa/svět, zimní, bez storna, individuál        |
| nIK10   | IK10       | t       | Evropa/svět, exclusiv turs, bez storna, individuál|
| nIK10+  | IK10       | zs      | Evropa/svět, exclusiv zimní, bez storna, individuál|
| nIK15   | IK15       | t       | Evropa/svět, exclusiv turs, bez storna, individuál|
| nIK15+  | IK15       | zs      | Evropa/svět, exclusiv zimní, bez storna, individuál|


### Generali Česká pojišťovna a.s. pojištění k letenkám 

- Označená sady **InsId**: 
  -  S
- Typ prodeje **ticketing**:
  -  A
- Typ pojištění **InsType**:
  - nená podporován, typ pojištění je dán kombinací InsProduct/CancProduct
- Area
  - W (šechny produkty mají celosvětovou platnost)

- Prodejní ceny a limity plnění jsou dostupné na stránkách (vyžaduje přihlášení):
  - https://www.everest2003.cz/modules.php?name=help

- Způsob zadávání produktů:
   
  | Zkratka              | InsProduct | CancProduct | Poznámka                                                       |
|----------------------|------------|-------------|----------------------------------------------------------------|
| Rozsah09             | Rozsah09   | -           | Storno letenky 10.000 Kč, SÚ 0 %                               |
| Rozsah10             | Rozsah10   | -           | Storno letenky 50.000 Kč, SÚ 0 %                               |
| Rozsah35             | Rozsah35   | -           | Komplet svět 60 dní turist, LV 10 mil., storno 100t., SÚ 0 %  |
| Rozsah36             | Rozsah36   | -           | Komplet svět 60 dní pracovní, LV 10 mil., storno 100t., SÚ 0 %|
| Rozsah37             | Rozsah37   | -           | Komplet svět 60 dní rekreacní sport, LV 10 mil., storno 100t., SÚ 0 %|
| Rozsah09 + Rozsah14  | Rozsah09   | Rozsah14    | Storno 10.000 Kč + komplet svět bez storna, turist, LV 10 mil.|
| Rozsah09 + Rozsah15  | Rozsah09   | Rozsah15    | Storno 10.000 Kč + komplet svět bez storna, pracovní, LV 10 mil.|
| Rozsah09 + Rozsah16  | Rozsah09   | Rozsah16    | Storno 10.000 Kč + komplet svět bez storna, rekreacní sport, LV 10 mil.|
| Rozsah10 + Rozsah14  | Rozsah10   | Rozsah14    | Storno 50.000 Kč + komplet svět bez storna, turist, LV 10 mil.|
| Rozsah10 + Rozsah15  | Rozsah10   | Rozsah15    | Storno 50.000 Kč + komplet svět bez storna, pracovní, LV 10 mil.|
| Rozsah10 + Rozsah16  | Rozsah10   | Rozsah16    | Storno 50.000 Kč + komplet svět bez storna, rekreacní sport, LV 10 mil.|
| Rozsah11             | Rozsah11   | -           | Komplet svět 60 dní turist, LV 10 mil., storno 100t., SÚ 20 % |
| Rozsah12             | Rozsah12   | -           | Komplet svět 60 dní pracovní, LV 10 mil., storno 100t., SÚ 20 %|
| Rozsah13             | Rozsah13   | -           | Komplet svět 60 dní rekreacní sport, LV 10 mil., storno 100t., SÚ 20 %|


### Generali Česká pojišťovna a.s. pojištění krátkodobých pobytů 

- Označená sady **InsId**: 
  -  S
- Typ prodeje **ticketing**:
  -  N
- Typ pojištění **InsType**:
  - nená podporován, typ pojištění je dán kombinací InsProduct/CancProduct
- Area
  - W - produkty mají celosvětovou platnost, nebo jsou omezené na Svět mimo USA a Kanady (viz poznámka)

- Prodejní ceny a limity plnění jsou dostupné na stránkách (vyžaduje přihlášení):
  - https://www.everest2003.cz/modules.php?name=help

| Zkratka  | InsProduct | Poznámka                                                                 |
|----------|------------|--------------------------------------------------------------------------|
| Rozsah07 | Rozsah07   | Turista svět, LV 6 mil., riziková cesta, storno 100 tis., SÚ 20 %       |
| Rozsah08 | Rozsah08   | Turista svět, LV 6 mil., riziková cesta, bez storna                     |
| Rozsah11 | Rozsah11   | Komplet svět 60 dní, turist, LV 10 mil., storno 100 tis., SÚ 20 %       |
| Rozsah12 | Rozsah12   | Komplet svět 60 dní, pracovní, LV 10 mil., storno 100 tis., SÚ 20 %     |
| Rozsah13 | Rozsah13   | Komplet svět 60 dní, rekreační sport, LV 10 mil., storno 100 tis., SÚ 20 % |
| Rozsah14 | Rozsah14   | Komplet svět bez storna 60 dní, turist, LV 10 mil.                      |
| Rozsah15 | Rozsah15   | Komplet svět bez storna 60 dní, pracovní, LV 10 mil.                    |
| Rozsah16 | Rozsah16   | Komplet svět bez storna 60 dní, rekreační sport, LV 10 mil.             |
| Rozsah35 | Rozsah35   | Komplet svět 60 dní, turist, LV 10 mil., storno 100 tis., SÚ 0 %        |
| Rozsah36 | Rozsah36   | Komplet svět 60 dní, pracovní, LV 10 mil., storno 100 tis., SÚ 0 %      |
| Rozsah37 | Rozsah37   | Komplet svět 60 dní, rekreační sport, LV 10 mil., storno 100 tis., SÚ 0 % |
| Rozsah41 | Rozsah41   | Komplet bez USA 30 dní, turist, LV 10 mil., storno 50 tis., SÚ 20 %     |
| Rozsah42 | Rozsah42   | Komplet bez USA 30 dní, pracovní, LV 10 mil., storno 50 tis., SÚ 20 %   |
| Rozsah43 | Rozsah43   | Komplet bez USA 30 dní, rekreační sport, LV 10 mil., storno 50 tis., SÚ 20 % |
| Rozsah44 | Rozsah44   | Komplet bez USA 30 dní, turist, LV 10 mil., storno 50 tis., SÚ 0 %      |
| Rozsah45 | Rozsah45   | Komplet bez USA 30 dní, pracovní, LV 10 mil., storno 50 tis., SÚ 0 %    |
| Rozsah46 | Rozsah46   | Komplet bez USA 30 dní, rekreační sport, LV 10 mil., storno 50 tis., SÚ 0 % |


### Generali Česká pojišťovna a.s. pojištění dlouhodobých pobytů 

- Označená sady **InsId**: 
  -  S
- Typ prodeje **ticketing**:
  -  N
- Typ pojištění **InsType**:
  - nená podporován, typ pojištění je dán kombinací InsProduct/CancProduct
- Area
  - W - produkty mají celosvětovou platnost, nebo jsou omezené na Svět mimo USA a Kanady (viz poznámka)

- Prodejní ceny a limity plnění jsou dostupné na stránkách (vyžaduje přihlášení):
  - https://www.everest2003.cz/modules.php?name=help

- Způsob zadávání produktů: 

| Zkratka    | InsProduct | Poznámka                                                                 |
|------------|------------|--------------------------------------------------------------------------|
| Rozsah17   | Rozsah17   | Komplet svět 90 dní, rekreační sport do 70 let, LV 10 mil.               |
| Rozsah18   | Rozsah18   | Komplet svět 180 dní, rekreační sport do 70 let, LV 10 mil.              |
| Rozsah19   | Rozsah19   | Komplet svět 365 dní, rekreační sport do 70 let, LV 10 mil.              |
| Rozsah20   | Rozsah20   | Komplet svět 90 dní, rekreační sport do 70 let, LV 100 mil.              |
| Rozsah21   | Rozsah21   | Komplet svět 180 dní, rekreační sport do 70 let, LV 100 mil.             |
| Rozsah22   | Rozsah22   | Komplet svět 365 dní, rekreační sport do 70 let, LV 100 mil.             |
| Rozsah23   | Rozsah23   | Komplet svět 90 dní, rekreační sport do 70 let, LV 10 mil., prolongační   |
| Rozsah24   | Rozsah24   | Komplet svět 180 dní, rekreační sport do 70 let, LV 10 mil., prolongační  |
| Rozsah25   | Rozsah25   | Komplet svět 365 dní, rekreační sport do 70 let, LV 10 mil., prolongační  |
| Rozsah26   | Rozsah26   | Komplet svět 90 dní, rekreační sport do 70 let, LV 100 mil., prolongační  |
| Rozsah27   | Rozsah27   | Komplet svět 180 dní, rekreační sport do 70 let, LV 100 mil., prolongační |
| Rozsah28   | Rozsah28   | Komplet svět 365 dní, rekreační sport do 70 let, LV 100 mil., prolongační |


### INTER PARTNER ASSISTANCE S. A. (IPA)

- Označená sady **InsId**: 
  -  A
- Typ prodeje **ticketing**:
  -  N
- Typ pojištění **InsType**:
  - není podporován, typ pojištění je dán kombinací InsProduct/CancProduct
- Area
  - produkty mají platnost podle vloženého InsProduct 

- Prodejní ceny a limity plnění jsou dostupné na stránkách (vyžaduje přihlášení):
  - https://www.everest2003.cz/modules.php?name=help

-Způsob zadávání produktů
| Základní sazby                        | InsProduct |
|--------------------------------------|------------|
| Komplet Evropa (K-E)                 | K-E        |
| Komplet celý svět (K-W)              | K-W        |
| Komplet svět, bez USA a Kanady       | K-EW       |
| Storno sólo SÚ 20%                   | STS        |

| Sazby připojištění storna                         | CancProduct |
|---------------------------------------------------|-------------|
| Storno k CP, SÚ 20%                               | PSS20       |
| Storno k CP, SÚ 0%                                | PSS0        |
| Storno k CP s karanténou,  SÚ 20%                 | PSKS20      |

| Další připojištění              | Název značky = 1/0 |
|---------------------------------|--------------------|
| Rizikové sporty                 | InsSport           |
| Drink povolen                   | InsDrink           |
| Připojištění práce a studia     | InsWork            |
| Chronické onemocnění            | InsChronic         |
| Autoasistence                   | InsAuto            |

## Popis metod

### Dotaz na získání nabídky produktů (`[InsuranceOrder]`)

| Název pole   | Popis                             | Typ / Formát         | Povinné  | Poznámka |
|--------------|------------------------------------|-----------------------|-----------|----------|
| `UserKey`    | Identifikátor prodejce             | `string` (max 64)     | Ano       | Slouží k autorizaci dotazu |
| `OrderId`    | Číslo objednávky                   | `string` (max 30)     | Ne        | -        |
| `DateFrom`   | Počátek pojištění                  | `date` (`dd.mm.yyyy`) | Ano       | -        |
| `DateTo`     | Konec cesty                        | `date` (`dd.mm.yyyy`) | Ano       | -        |
| `NumPerson`  | Počet osob                         | `integer`             | Ano       | Není omezeno |
| `Area`       | Riziková oblast                    | `enum`                | Ne*       | `E` - Evropa, `W` - Svět. **Povinné**, pokud není vyplněno `Country` |
| `Country`    | Cílová země                        | `string` (3 znaky)    | Ne*       | ISO 3166-1 alpha-3. **Povinné**, pokud není vyplněno `Area` |
| `InsId`      | Kód pojišťovny                     | `enum`                | Ano       | Viz číselník |
| `InsType`    | Typ pojištění                      | `enum`                | Ano       | `t` - turistická, `zs` - zimní sporty |
| `CancValue`  | Max. výše pojistného krytí (v tis.)| `enum`                | Podmíněně| Hodnoty: 10, 50, 100. Povinné, pokud `Ticketing = A` |
| `TourPrice`  | Cena zájezdu za osobu              | `float`               | Ne        | Max. cena za osobu (je-li více osob) |
| `Currency`   | Měna                               | `string` (3 znaky)    | Ne        | ISO kód měny. Výchozí `CZK` |
| `Email`      | Email klienta                      | `string` (max 64)     | Ne        | -        |
| `Ticketing`  | Prodej letenek                     | `char` (1 znak)       | Ano       | `A` - ano, `N` - ne |
| `Status`     | Příznak operace                    | `enum`                | Ano       | `K` - kalkulace |

\* `Area` a `Country` – musí být vyplněno alespoň jedno z nich.

#### Příklad dotazu 

```json
{
   "InsuranceOrder":{
      "UserKey":"41059e28e30af11f62473ee29a93b2e1",
      "OrderId":"20251010",
      "DateFrom":"10.10.2025",
      "DateTo":"15.10.2025",
      "NumPerson":2,
      "Area":"E",
      "InsId":"W",
      "InsType":"t",
      "CancValue":50,
      "TourPrice":20000,
      "Currency":"CZK",
      "Email":"vir2al3vel@gmail.com",
      "Ticketing":"N",
      "Status":"K"
   }
}

```

#### Struktura odpovědi: `InsuranceResponse`

| Název pole           | Popis                                     | Typ / Formát     | Poznámka |
|----------------------|--------------------------------------------|------------------|----------|
| `ProductData`        | Sada kalkulovaných produktů                | `object`         | Obsahuje 1..N položek ve tvaru `Product_X` |

Struktura objektu `Product_X` (např. `Product_1`)

| Název pole     | Popis                                              | Typ / Formát     | Poznámka |
|----------------|-----------------------------------------------------|------------------|----------|
| `InsProduct`   | Kód pojistného produktu                            | `string` (max 5) | Např. `IK5S` |
| `TotalPremium` | Celková výše pojistného                           | `float`          | V měně dle pole `Currency` |
| `Currency`     | Měna pojistného                                    | `string` (3 znaky) | Např. `CZK` |
| `Description`  | Popis produktu                                     | `string`         | Lidsky čitelný název produktu |
| `InsId`        | Kód pojišťovny                                     | `string` (1 znak) | Např. `S` (viz číselník pojišťoven) |


#### Příklad odpovědi

```json
    "InsuranceResponse": {
        "ProductData": {
            "Product_1": {
                "InsProduct": "IK5S",
                "TotalPremium": 408,
                "Currency": "CZK",
                "Description": "Komplet se stornem turs individuál 2019 UNIQA",
                "InsId": "S"
            },
...
```

### Kalkulace/Objednávka/Vytvoření pojištění pro konkrétní osoby (`[InsuranceOrder]`)

#### Definice parametrů metody:

| Název pole    | Popis                             | Typ / Formát           | Povinné  | Poznámka |
|---------------|------------------------------------|------------------------|----------|----------|
| `UserKey`     | Identifikátor prodejce            | `string` (max 64)      | Ano      | Slouží k autorizaci dotazu |
| `OrderId`     | Číslo objednávky                  | `string` (max 30)      | Ne      | Vlastní číselná řada |
| `DateFrom`    | Počátek pojištění                 | `date` (`dd.mm.yyyy`)  | Ano      | - |
| `DateTo`      | Konec cesty                        | `date` (`dd.mm.yyyy`)  | Ano      | - |
| `Area`        | Riziková oblast                   | `enum`                 | Ne*      | `E` - Evropa, `W` - Svět. **Povinné**, pokud není vyplněno `Country` |
| `Country`     | Cílová země                       | `string` (3 znaky)     | Ne*      | ISO 3166-1 alpha-3. **Povinné**, pokud není vyplněno `Area` |
| `InsId`       | Kód pojišťovny                    | `enum`                 | Ne      | Viz číselník |
| `InsType`     | Typ pojištění                     | `enum`                 | Ano      | `t` - turistická, `zs` - zimní sporty |
| `PlateNumber` | Registrační značka vozidla        | `string` (max 7)       | Podmíněně| Povinné pro sazby `K5A` a `K5SA` |
| `CancValue`   | Max. výše pojistného krytí (v tis.)| `enum`                 | Podmíněně| Hodnoty: 10, 50, 100. Povinné, pokud `Ticketing = A` |
| `TourPrice`   | Cena zájezdu za osobu             | `float`                | Ne       | Max. cena za osobu (je-li více osob) |
| `Currency`    | Měna                              | `string` (3 znaky)     | Ne       | ISO kód měny. Výchozí `CZK` |
| `Email`       | Email klienta                     | `string` (max 64)      | Ne       | - |
| `Ticketing`   | Prodej letenek                    | `char` (1 znak)        | Ano      | `A` - ano, `N` - ne |
| `Status` | Příznak operace              | `enum`                 | Ano      | `K` - kalkulace,  `O` - objednávka (nezaplaceno),  `N` - objednávka s úhradou |
| `MailToPay`   | Indikátor online platby           | `enum`                 | Podmíněně| `A` - klientovi je zaslán mail s adresou pro platbu, `N` - v odpovědi je vrácen hash pro provedení platby |
| `MarchantUrl` | Internetová adresa obchodníka     | `string` (max 128)     | Ne       | Pokud obchodník vyžaduje úpravu kódu platební stránky |
| `Passengers`  | Seznam osob                | `object`         | Obsahuje 1..N položek ve tvaru `Person_X` |

**Objekty osob (`Passenger`) jsou prvky objektu `Passengers`**

| Název pole     | Popis                               | Typ / Formát        | Příklad hodnot | Poznámka |
|----------------|--------------------------------------|---------------------|----------------|----------|
| `PersonId`     | Identifikátor osoby                 | `integer`           | 1              | Pořadové číslo osoby |
| `LastName`     | Příjmení                            | `string` (max 80)   | Tester         | Uvádět bez titulů |
| `FirstName`    | Jméno                               | `string` (max 80)   | Miroslav       | Uvádět bez titulů |
| `BirthDate`    | Datum narození                      | `date` (`dd.mm.yyyy`)| 12.12.1960     | -        |
| `InsProduct`   | Kód sazby                           | `string` (max 5)    | K5             | -        |
| `CancProduct`  | Typ storna IPA                      | `enum`              | PSS0           | Pouze pro produkty IPA |
| `InsSport`     | Připojištění rizikových sportů      | `integer` (0/1)     | 1              | Pouze IPA |
| `InsDrink`     | Připojištění „Drink povolen“        | `integer` (0/1)     | 0              | Pouze IPA |
| `InsWork`      | Připojištění práce a studia         | `integer` (0/1)     | 1              | Pouze IPA |
| `InsChron`     | Chronické onemocnění                | `integer` (0/1)     | 0              | Pouze IPA |
| `InsAuto`      | Autoasistence                       | `integer` (0/1)     | 1              | Pouze IPA |
| `InsType`      | Typ pojištění                       | `enum`              | t              | `t` - turistická, `zs` - zimní sporty. Neuvádět u IPA |
| `TourPrice`    | Cena zájezdu                        | `float`             | 8000           | Povinné, pokud není uvedeno v objednávce |


#### Příklad dotazu
```json
{
    "InsuranceOrder": {
        "UserKey": "41059e28e30af11f62473ee29a93b2e1",
        "DateFrom": "01.12.2025",
        "DateTo": "05.12.2025",
        "Area": "e",
        "Email": "vir2al3vel@gmail.com",
        "Currency": "CZK",
        "Status": "N",
        "Passengers": {
            "Passanger_1": {
                "PersonId": "1",
                "LastName": "Tester",
                "FirstName": "Jan",
                "BirthDate": "01.01.1980",
                "InsType": "t",
                "InsProduct": "K10"
            },
            "Passanger_2": {
                "PersonId": "2",
                "LastName": "Tester",
                "FirstName": "Ivo",
                "BirthDate": "24.12.1960",
                "InsType": "t",
                "InsProduct": "K15"
            }
        }
    }
}
```
#### Struktura odpovědi: `InsuranceResponse`

| Název pole            | Popis                                      | Typ / Formát         | Příklad hodnot     | Poznámka                 |
|------------------------|---------------------------------------------|-----------------------|---------------------|---------------------------|
| `OrderId`              | Číslo objednávky                           | `string`              | "250504125130"      | Identifikátor objednávky |
| `InsId`                | Kód pojišťovny                             | `string`              | "Z"                 | Dle číselníku pojišťoven |
| `TotalPremium`         | Celková výše pojistného                    | `float`               | 505                 | Za všechny osoby celkem  |
| `Currency`             | Měna pojistného                            | `string` (3 znaky)    | "CZK"               | ISO 4217 kód měny         |
| `PassengerData`        | Informace o pojištěných osobách            | `object`              | `{Person_1, ...}`   | Viz podřízená tabulka níže |
| `ContractNo`           | Číslo smlouvy                              | `string`              | "1445389"           | Generované číslo smlouvy |
| `AccessKey`            | Klíč pro přístup k datům                   | `string`              | "15642d5d5f6e..."   | Hash přístupového klíče  |
| `TID`                  | Identifikátor transakce                    | `string`              | "UytreDFvbFlO..."   | Zakódovaný identifikátor |

**Struktura objektu PassengerData → Person_X**
| Název pole        | Popis                               | Typ / Formát       | Příklad hodnot | Poznámka                |
|-------------------|--------------------------------------|---------------------|----------------|--------------------------|
| `PersonId`        | ID osoby dle požadavku               | `string`            | "1"            | Shodné s `PersonId` v požadavku |
| `PersonNr`        | Interní číslo osoby                  | `integer`           | 3575683        | Přiděleno pojišťovnou     |
| `InsProduct`      | Kód pojistného produktu              | `string` (max 5)    | "K10"          | -                        |
| `PersonPremium`   | Pojistné za osobu                    | `float`             | 250            | -                        |


#### Příklad odpovědi

```json
{
    "InsuranceResponse": {
        "OrderId": "250504125130",
        "InsId": "Z",
        "TotalPremium": 505,
        "Currency": "CZK",
        "PassengerData": {
            "Person_1": {
                "PersonId": "1",
                "PersonNr": 3575683,
                "InsProduct": "K10",
                "PersonPremium": 250
            },
            "Person_2": {
                "PersonId": "2",
                "PersonNr": 3575684,
                "InsProduct": "K15",
                "PersonPremium": 255
            }
        },
        "ContractNo": "1445389",
        "AccessKey": "15642d5d5f6e1a33221db40961344d95",
        "TID": "UytreDFvbFlON09CdVpsYVhhVk0rUT09"
    }
}
```