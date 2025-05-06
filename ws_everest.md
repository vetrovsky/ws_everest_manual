# WS EVEREST2003 – Uživatelská příručka

**Verze:** 4.0  
**Datum:** 6. května 2025  
**Účel:** Tento dokument popisuje strukturu a použití webové služby WS EVEREST2003 pro partnery.

---

Všechna práva vyhrazena **TRAVEL SUPPORT SYSTEMS s.r.o.**, zapsaná u KS Brno, oddíl C, vložka 50606.  
Tento dokument je určen **výhradně pro interní potřebu obchodních partnerů** společnosti a **nesmí být dále šířen ani zveřejněn** bez předchozího písemného souhlasu.

**Kontakt:**  
Dotazy a návrhy k implementaci služby prosím zasílejte na: [it@travspsys.cz](mailto:it@travspsys.cz)

**CEO:** Luděk Miler sen.  
📞 +420 777 941 454 (CZ)  
📞 +421 948 941 454 (SK)


## Obsah

- [Úvod](#ws-everest2003--uživatelská-příručka)
- [Způsob použití služby](#způsob-použití-služby)
- [Volání služby](#volání-služby)
- [Typy pojištění a jejich obsah](#typy-pojištění-a-jejich-obsah)
  - [UNIQA pojišťovna, a.s.](#uniqa-pojišťovna-as)
  - [Individuální sazby UNIQA pojišťovna, a.s.](#individuální-sazby-uniqa-pojišťovna-as)
  - [Generali Česká pojišťovna a.s. pojištění k letenkám](#generali-česká-pojišťovna-as-pojištění-k-letenkám)
  - [Generali Česká pojišťovna a.s. pojištění krátkodobých pobytů](#generali-česká-pojišťovna-as-pojištění-krátkodobých-pobytů)
  - [Generali Česká pojišťovna a.s. pojištění dlouhodobých pobytů](#generali-česká-pojišťovna-as-pojištění-dlouhodobých-pobytů)
  - [INTER PARTNER ASSISTANCE S. A. (IPA)](#inter-partner-assistance-s-a-ipa)
- [Popis metod](#popis-metod)
  - [Dotaz na získání nabídky produktů](#dotaz-na-získání-nabídky-produktů-insuranceorder)
  - [Kalkulace/Objednávka/Vytvoření pojištění pro konkrétní osoby](#kalkulaceobjednávkavytvoření-pojištění-pro-konkrétní-osoby-insuranceorder)
  - [Aktivace objednávky](#aktivace-objednávky)
  - [Odeslání mailu](#odeslání-mailu)
  - [Informace o objednávce](#informace-o-objednávce)
  - [Stornování neuhrazené objednávky](#stornování-neuhrazené-objednávky)
  - [Nahlášení storna](#nahlášení-storna)
- [Příloha: Seznam chybových kódů v ErrorResponse](#příloha-seznam-chybových-kódů-v-errorresponse)

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
            }
        }
    }
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

| Název pole    | Popis                          | Typ / Formát          | Povinné | Poznámka                                              |
| ------------- | ------------------------------ | --------------------- | ------- | ----------------------------------------------------- |
| `PersonId`    | Identifikátor osoby            | `integer`             | Ano     | Pořadové číslo osoby                                  |
| `LastName`    | Příjmení                       | `string` (max 80)     | Ano     | Uvádět bez titulů                                     |
| `FirstName`   | Jméno                          | `string` (max 80)     | Ano     | Uvádět bez titulů                                     |
| `BirthDate`   | Datum narození                 | `date` (`dd.mm.yyyy`) | Ano     | -                                                     |
| `InsProduct`  | Kód sazby                      | `string` (max 5)      | Ano     | -                                                     |
| `CancProduct` | Typ storna IPA                 | `enum`                | Ne      | Pouze pro produkty IPA                                |
| `InsSport`    | Připojištění rizikových sportů | `integer` (0/1)       | Ne      | Pouze IPA                                             |
| `InsDrink`    | Připojištění „Drink povolen“   | `integer` (0/1)       | Ne      | Pouze IPA                                             |
| `InsWork`     | Připojištění práce a studia    | `integer` (0/1)       | Ne      | Pouze IPA                                             |
| `InsChron`    | Chronické onemocnění           | `integer` (0/1)       | Ne      | Pouze IPA                                             |
| `InsAuto`     | Autoasistence                  | `integer` (0/1)       | Ne      | Pouze IPA                                             |
| `InsType`     | Typ pojištění                  | `enum`                | Ne      | `t` - turistická, `zs` - zimní sporty. Neuvádět u IPA |
| `TourPrice`   | Cena zájezdu                   | `float`               | Ano\*   | Povinné, pokud není uvedeno v objednávce              |



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

| Název pole      | Popis                           | Typ / Formát       | Poznámka                   |
| --------------- | ------------------------------- | ------------------ | -------------------------- |
| `OrderId`       | Číslo objednávky                | `string`           | Identifikátor objednávky   |
| `InsId`         | Kód pojišťovny                  | `string`           | Dle číselníku pojišťoven   |
| `TotalPremium`  | Celková výše pojistného         | `float`            | Za všechny osoby celkem    |
| `Currency`      | Měna pojistného                 | `string` (3 znaky) | ISO 4217 kód měny          |
| `PassengerData` | Informace o pojištěných osobách | `object`           | Viz podřízená tabulka níže |
| `ContractNo`    | Číslo smlouvy                   | `string`           | Generované číslo smlouvy   |
| `AccessKey`     | Klíč pro přístup k datům        | `string`           | Hash přístupového klíče    |
| `TID`           | Token pro přístup k dokumentům obch.případu| `string`|    |


**Struktura objektu PassengerData → Person_X**
| Název pole      | Popis                   | Typ / Formát     | Poznámka                        |
| --------------- | ----------------------- | ---------------- | ------------------------------- |
| `PersonId`      | ID osoby dle požadavku  | `string`         | Shodné s `PersonId` v požadavku |
| `PersonNr`      | Interní číslo osoby     | `integer`        | Přiděleno pojišťovnou           |
| `InsProduct`    | Kód pojistného produktu | `string` (max 5) | -                               |
| `PersonPremium` | Pojistné za osobu       | `float`          | -                               |


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

### Aktivace objednávky

Vytvořenou neuhrazenou objednávku se stavu **O** je možné nastavit do uhrazeného stavu **N** metodou `PaymentConfirmation`.

#### Definice parametrů metody `PaymentConfirmation`

| Název pole    | Popis                                      | Typ / Formát      | Povinné | 
|---------------|---------------------------------------------|--------------------|-----------------------------|
| `UserKey`     | Identifikátor prodejce                     | `string` (max 64)  | ano                           | 
| `AccessKey`   | Přístupový kód                             | `string` (max 64)  | ano                          | 
| `OrderId`     | Číslo objednávky                           | `string` (max 30)  | Podmíněně*                           |
| `ContractNo`  | Číslo smlouvy/návrhu                       | `string` (max 10)  | Podmíněně*                            | 

V metodě je povinné některé z polí `OrderId` nebo  `ContractNo`

#### Příklad dotazu

```json
{
    "PaymentConfirmation": {
        "OrderId": "123",
        "UserKey": "41059e28e30af11f62473ee29a93b2e1",
        "AccessKey": "33359e28e30af11f62473ee29a93b2e1"
    }
}
```
#### Struktura odpovědi: `PaymentConfirmationResponse`

| Název pole | Popis            | Typ / Formát      |
| ---------- | ---------------- | ----------------- |
| `OrderId`  | Číslo objednávky | `string` (max 30) |

Contracts (obsahuje 1..N prvků Contract_XXXX)

| Název pole     | Popis                | Typ / Formát       |
| -------------- | -------------------- | ------------------ |
| `AccessKey`    | Přístupový kód       | `string` (max 64)  |
| `ContractNo`   | Číslo smlouvy/návrhu | `string` (max 10)  |
| `InsId`        | Kód pojišťovny       | `enum`             |
| `TotalPremium` | Celkové pojistné     | `float`            |
| `Currency`     | Měna (ISO kód)       | `string` (3 znaky) |
| `Status`       | Stav smlouvy         | `enum`             |

Passengers (každá smlouva obsahuje 1..N prvků Person_XX)

| Název pole      | Popis                               | Typ / Formát     |
| --------------- | ----------------------------------- | ---------------- |
| `PersonId`      | Identifikátor osoby                 | `integer`        |
| `PersonNr`      | Číslo záznamu osoby u provozovatele | `integer`        |
| `InsProduct`    | Kód sazby                           | `string` (max 6) |
| `PersonPremium` | Pojistné za osobu                   | `float`          |

#### Příklad odpovědi

```json
{
    "PaymentConfirmationResponse": {
        "OrderId": "250505192434",
        "Contracts": {
            "Contract_1445503": {
                "ContractNo": "1445503",
                "InsId": "Z",
                "TotalPremium": 505,
                "Currency": "CZK",
                "Status": "N",
                "Passengers": {
                    "Passenger_1": {
                        "PersonId": "1",
                        "PersonNr": "3576020",
                        "Status": "O"
                    },
                    "Passenger_2": {
                        "PersonId": "2",
                        "PersonNr": "3576021",
                        "Status": "O"
                    }
                }
            }
        }
    }
}
```

### Odeslání mailu

Klientovi je možné zaslat návrh pojištění pomocí metody `SendEmail`

#### Definice parametrů metody `SendEmail`
| Název pole   | Popis                  | Typ / Formát      | Povinné     |
| ------------ | ---------------------- | ----------------- | ----------- |
| `UserKey`    | Identifikátor prodejce | `string` (max 64) | ano         |
| `AccessKey`  | Přístupový kód         | `string` (max 64) | ano         |
| `OrderId`    | Číslo objednávky       | `string` (max 30) | Podmíněně\* |
| `ContractNo` | Číslo smlouvy/návrhu   | `string` (max 10) | Podmíněně\* |
| `Email`      | Email příjemce         | `string` (max 64) | ne (odesání na email z objednávky)|

V metodě je povinné některé z polí `OrderId` nebo  `ContractNo`

#### Příklad dotazu

```json
{
    "SendEmail": {
        "ContractNo": "1445503",
        "UserKey": "41059e28e30af11f62473ee29a93b2e1",
        "AccessKey": "eb888cdbed26cf4c78a25aa2fa861166",
        "Email": "vir2al3vel@gmail.com"
    }
}

```

#### Struktura odpovědi `SendEmailResponse`:

| Název pole   | Popis                | Typ / Formát      |
| ------------ | -------------------- | ----------------- |
| `OrderId`  | Číslo objednávky | `string` (max 30) |
| `ContractNo` | Číslo smlouvy/návrhu | `string` (max 10) |
| `Status`     | Stav smlouvy         | `enum`            |
| `Email`      | Email příjemce       | `string` (max 64) |


#### Příklad odpovědi

```json
{
    "SendEmailResponse": {
        "ContractNo": "1445503",
        "OrderId": "250505192434",
        "Status": "N",
        "Email": "vir2al3vel@gmail.com"
    }
}

```

### Informace o objednávce

Ziskání podrobných informací o stavu návrhu pomocí metody `OrderInfo`

#### Definice parametrů metody `OrderInfo`
| Název pole    | Popis                                      | Typ / Formát      | Povinné | 
|---------------|---------------------------------------------|--------------------|-----------------------------|
| `UserKey`     | Identifikátor prodejce                     | `string` (max 64)  | ano                           | 
| `AccessKey`   | Přístupový kód                             | `string` (max 64)  | ano                          | 
| `OrderId`     | Číslo objednávky                           | `string` (max 30)  | Podmíněně*                           |
| `ContractNo`  | Číslo smlouvy/návrhu                       | `string` (max 10)  | Podmíněně*                            | 

V metodě je povinné některé z polí `OrderId` nebo  `ContractNo`

#### Příklad dotazu

```json
{
    "OrderInfo": {
      "UserKey": "41059e28e30af11f62473ee29a93b2e1",
      "AccessKey": "eb888cdbed26cf4c78a25aa2fa861166",
      "ContractNo": "1445503"
    }
}

```

#### Struktura odpovědi `InfoResponse`:

| Název pole | Popis            | Typ / Formát      | Použití          |
| ---------- | ---------------- | ----------------- | ---------------- |
| `OrderId`  | Číslo objednávky | `string` (max 30) | Objednávkový kód |

**Contracts – Smlouvy / návrhy (1..N prvků Contract_XXXX)**

| Název pole     | Popis                                    | Typ / Formát        |
|----------------|-------------------------------------------|---------------------|
| `ContractNo`   | Číslo smlouvy/návrhu                      | `string` (max 10)   |
| `AccessKey`    | Přístupový kód (autorizace objednávky)   | `string` (max 64)   |
| `TID`          | Token pro přístup k dokumentům obch.případu| `string` (max 64)   |
| `DateFrom`     | Počátek pojištění                        | `date` (dd.mm.yyyy) |
| `DateTo`       | Konec cesty                              | `date` (dd.mm.yyyy) |
| `NumPerson`    | Počet osob                               | `int`               |
| `Area`         | Riziková oblast *(E – Evropa, W – Svět)* | `enum`              |
| `Country`      | Cílová země                              | `string`            |
| `CountryISO`   | Cílová země (ISO 3166-1 alpha-3)         | `string` (3 znaky)  |
| `InsId`        | Kód pojišťovny                           | `enum`              |
| `TotalPremium` | Celkové pojistné                         | `float`             |
| `Currency`     | Měna (ISO kód, např. CZK)                | `string` (3 znaky)  |
| `Status`       | Stav záznamu: `O`, `N`, `X`              | `enum`              |
| `Email`        | Email klienta                            | `string` (max 64)   |
| `InsertTime`   | Datum vložení záznamu                    | `timestamp`         |
| `PaymentTime`  | Datum platby (aktivace)                  | `timestamp`         |

**Passengers – Osoby (1..N prvků Person_XX)**

| Název pole         | Popis                                          | Typ / Formát        | Poznámka             |
| ------------------ | ---------------------------------------------- | ------------------- | -------------------- |
| `PersonId`         | Identifikátor osoby                            | `int`               |                      |
| `LastName`         | Příjmení                                       | `string` (max 80)   | bez titulů    |
| `FirstName`        | Jméno                                          | `string` (max 80)   | bez titulů    |
| `BirthDate`        | Datum narození                                 | `date` (dd.mm.yyyy) |                      |
| `InsProduct`       | Kód sazby                                      | `string` (max 5)    |                      |
| `InsType`          | Typ pojištění (`t` – turistická, `zs` – zimní) | `enum`              |                      |
| `CancProduct`      | Typ storna                                     | `enum`              | pouze IPA            |
| `InsSport`     | Připojištění rizikových sportů      | `integer` (0/1)     | 1              | Pouze IPA |
| `InsDrink`     | Připojištění „Drink povolen“        | `integer` (0/1)     | 0              | Pouze IPA |
| `InsWork`      | Připojištění práce a studia         | `integer` (0/1)     | 1              | Pouze IPA |
| `InsChron`     | Chronické onemocnění                | `integer` (0/1)     | 0              | Pouze IPA |
| `InsAuto`      | Autoasistence                       | `integer` (0/1)     | 1              | Pouze IPA |
| `TourPrice`    | Cena zájezdu                        | `float`             | 8000           | Povinné, pokud není uvedeno v objednávce |

#### Příklad odpovědi

```json
{
    "InfoResponse": {
        "OrderId": "",
        "Contracts": {
            "Contract_1445503": {
                "ContractNo": "1445503",
                "AccessKey": "eb888cdbed26cf4c78a25aa2fa861166",
                "TID": "RHUwYVpWalZ5SDl3M0d4KytieURZUT09",
                "DateFrom": "01.12.2025",
                "DateTo": "05.12.2025",
                "NumPerson": 2,
                "Area": "Evropa",
                "Country": "",
                "CountryISO": "",
                "InsId": "Z",
                "TotalPremium": 505,
                "Currency": "CZK",
                "Status": "N",
                "Email": "vir2al3vel@gmail.com",
                "InsertTime": "05.05.2025 19:24",
                "PaymentTime": "05.05.2025 19:25",
                "Passengers": {
                    "Passenger_1": {
                        "PersonId": "1",
                        "PersonNr": "3576020",
                        "LastName": "TESTER",
                        "FirstName": "LUDEK",
                        "BirthDate": "01.01.1980",
                        "InsProduct": "nK10",
                        "InsType": "t",
                        "PersonPremium": "250"
                    },
                    "Passenger_2": {
                        "PersonId": "2",
                        "PersonNr": "3576021",
                        "LastName": "TESTER",
                        "FirstName": "ROMAN",
                        "BirthDate": "24.12.1960",
                        "InsProduct": "nK15",
                        "InsType": "t",
                        "PersonPremium": "255"
                    }
                },
                "Documents": {
                    "Document_1": {
                        "Name": "Asistenční kartičky",
                        "Url": "https://www.everest2003.cz/modules.php?format=karta&name=Prehled_potvrzeni&tid=RHUwYVpWalZ5SDl3M0d4KytieURZUT09"
                    },
                    "Document_2": {
                        "Name": "Potvrzení o sjednaném pojištění",
                        "Url": "https://www.everest2003.cz/modules.php?format=pdf&name=Prehled_potvrzeni&tid=RHUwYVpWalZ5SDl3M0d4KytieURZUT09"
                    },
                    "Document_3": {
                        "Name": "Potvrzení o rozsahu pojistného krytí v angličtině",
                        "Url": "https://www.everest2003.cz/modules.php?format=info&name=Prehled_potvrzeni&tid=RHUwYVpWalZ5SDl3M0d4KytieURZUT09"
                    },
                    "Document_4": {
                        "Name": "Všeobecné pojistné podmínky UCZ/Ces/20",
                        "Url": "https://www.travsupsys.cz/download/EU_53611E_Ces20.pdf"
                    },
                    "Document_5": {
                        "Name": "Doplňkové pojistné podmínky DPP/Ces/A/20",
                        "Url": "https://www.travsupsys.cz/download/EU_53621E_Dpp_A20.pdf"
                    },
                    "Document_6": {
                        "Name": "Informační dokument k cestovnímu pojištění",
                        "Url": "https://www.travsupsys.cz/download/UNIQA_IPID_UCZ_CP.pdf"
                    },
                    "Document_7": {
                        "Name": "Zpracování osobních údajů, informace a souhlasy správce",
                        "Url": "https://www.travsupsys.cz/download/info_gdpr_uniqa.pdf"
                    },
                    "Document_8": {
                        "Name": "Formulář pro hlášení škody storna zájezdu",
                        "Url": "https://www.travsupsys.cz/download/PU_Uniqa_ST.pdf"
                    },
                    "Document_9": {
                        "Name": "Formulář pro hlášení škody z léčebných výloh, odpovědnosti a zavazadel",
                        "Url": "https://www.travsupsys.cz/download/PU_Uniqa_CP.pdf"
                    },
                    "Document_10": {
                        "Name": "Formulář pro hlášení škody z úrazového pojištění",
                        "Url": "https://www.travsupsys.cz/download/PU_Uniqa_UP.pdf"
                    },
                    "Document_11": {
                        "Name": "Pokyny pro hlášení pojistné události ON-LINE",
                        "Url": "https://www.travsupsys.cz/download/PU_Uniqa_pokyny.pdf"
                    }
                }
            }
        }
    }
}
```

### Stornování neuhrazené objednávky 

Pro zrušení objednávky je určena metoda `OrderDelete`.

#### Definice parametrů metody:

### Definice metody pro výmaz záznamu

| Název pole    | Popis                                                      | Typ / Formát       | Povinné |
|---------------|-------------------------------------------------------------|--------------------|---------|
| `UserKey`     | Identifikátor prodejce (autorizace dotazu)                 | `string` (max 64)  | Ano     |
| `AccessKey`   | Přístupový kód (autorizace objednávky)                     | `string` (max 64)  | Ano     |
| `OrderId`     | Číslo objednávky                                            | `string` (max 30)  | Ano*    |
| `ContractNo`  | Číslo smlouvy/návrhu                                        | `string` (max 10)  | Ano*    |
| `PersonNr`    | Číslo záznamu osoby (smaže pouze konkrétní osobu, pokud uvedeno) | `int`         | Ne      |

#### Příklad dotazu 

```json
{
    "OrderDelete": {
        "ContractNo": "1445528",
        "UserKey": "41059e28e30af11f62473ee29a93b2e1",
        "AccessKey": "dd4831ff93f99ef561f28acb28fb2e5a"
    }
}
```

#### Struktura odpovědi: `OrderDeleteResponse`

| Název pole     | Popis               | Typ / Formát       | Povinné |
|----------------|---------------------|---------------------|----------|
| `OrderId`      | Číslo objednávky     | `string` (max 30)   | Ano      |

**Objekt `Contracts` (může obsahovat více prvků `Contract_XXXX`)**

| Název pole       | Popis                        | Typ / Formát       | 
|------------------|-------------------------------|---------------------|
| `ContractNo`     | Číslo smlouvy/návrhu          | `string` (max 10)   |
| `TotalPremium`   | Celkové pojistné              | `float`             |
| `Currency`       | Měna (ISO kód, např. CZK)     | `string` (3 znaky)  |
| `Status`         | Stav záznamu (`X` = Stornováno)| `enum`              |

**Objekt `DeletedPassengers`**

| Název pole     | Popis                   | Typ / Formát       | 
|----------------|--------------------------|---------------------|
| `PersonId`     | Identifikátor osoby      | `string` nebo `int` |
| `PersonNr`     | Číslo záznamu osoby      | `string` nebo `int` |
| `Status`       | Stav osoby (`X` = smazáno)| `enum`              |

#### Příklad odpovědi 

```json
{
    "OrderDeleteResponse": {
        "OrderId": "",
        "Contracts": {
            "Contract_1445528": {
                "ContractNo": "1445528",
                "TotalPremium": 0,
                "Currency": "CZK",
                "Status": "X",
                "DeletedPassengers": {
                    "Passenger_1": {
                        "PersonId": "1",
                        "PersonNr": "3576100",
                        "Status": "X"
                    }
                }
            }
        }
    }
}
```

### Definice metody pro nahlášení storna

Nahlášení storna zájezdu/služby včetně detailního vyúčtování je určena `TripCancellation`

| Název pole                       | Popis                                                   | Typ / Formát        | Povinné |
| -------------------------------- | ------------------------------------------------------- | ------------------- | ------- |
| `UserKey`                        | Identifikátor prodejce                                  | `string` (max 64)   | Ano     |
| `AccessKey`                      | Přístupový kód                                          | `string` (max 64)   | Ano     |
| `Organizer`                      | Pořadatel zájezdu / prodejce stornovaných služeb        | `string`            | Ano     |
| `OrderId`                        | Identifikátor zájezdu/služby                            | `string`            | Ano     |
| `DateFrom`                       | Termín zahájení                                         | `date` (DD.MM.YYYY) | Ano     |
| `DateTo`                         | Termín ukončení                                         | `date` (DD.MM.YYYY) | Ano     |
| `DestinationType`                | Druh zájezdu nebo služby (např. Evropa/pobytový)        | `string`            | Ano     |
| `Billing.Price`                  | Cena zájezdu dle smlouvy (bez pojištění)                | `float`             | Ano     |
| `Billing.PaidByCustomer`         | Uhrazeno zákazníkem (bez pojištění)                     | `float`             | Ano     |
| `Billing.LastPaymentDate`        | Datum poslední nebo jednorázové úhrady                  | `date` (DD.MM.YYYY) | Ano     |
| `Billing.CancellationReportDate` | Datum nahlášení storna od zákazníka                     | `date` (DD.MM.YYYY) | Ano     |
| `Billing.CancellationPrice`      | Cena služeb za osoby uplatňující storno (bez pojištění) | `float`             | Ano     |
| `Billing.CancellationFeeClaimed` | Nárokované stornopoplatky CK/CA                         | `float`             | Ano     |
| `Billing.RefundToCustomer`       | Částka vrácená zákazníkovi                              | `float`             | Ano     |
| `Billing.RefundDate`             | Datum výplaty zákazníkovi                               | `date` (DD.MM.YYYY) | Ano     |
| `Billing.InsuredCosts`           | Výše škody z pojistné události                          | `float`             | Ano     |
| `Notes`                          | Poznámka CK                                             | `string`            | Ne      |

#### Příklad dotazu 
```json
{
    "TripCancellation": {
        "UserKey": "41059e28e30af11f62473ee29a93b2e1",
        "AccessKey": "de7d480048cd1f1d615231fd053357f3",
        "Organizer": "České Kormidlo TEST",
        "OrderId": "241209121836",
        "DateFrom": "01.07.2024",
        "DateTo": "15.07.2024",
        "DestinationType": "Evropa/pobytový",
        "Billing": {
            "Price": 2500,
            "PaidByCustomer": 2000,
            "LastPaymentDate": "15.05.2024",
            "CancellationReportDate": "10.06.2024",
            "CancellationPrice": 1800,
            "CancellationFeeClaimed": 300,
            "RefundToCustomer": 1500,
            "RefundDate": "15.06.2024",
            "InsuredCosts": 1200
        },
        "Notes": "Customer cancelled due to health issues."
    }
}
```
#### Struktura odpovědi: `TripCancellationResponse`

| Název pole | Popis                                     | Typ / Formát   | 
| ---------- | ----------------------------------------- | -------------- | 
| `FormUrl`  | URL adresa formuláře pro doplnění         | `string (URL)` |
| `FormFile` | URL ke stažení PDF formuláře              | `string (URL)` |
| `Status`   | Stav požadavku: `OK` nebo `ErrorResponse` | `string`       |

#### Příklad odpověďi

```json
{
    "TripCancellationResponse": {
        "FormUrl": "https://www.everest2003.cz/modules.php?name=Vyucto_storna&hash=L093OWNBY0FUM3lMd0hVQW5iMTlOdz09&id=4336",
        "FormFile": "https://www.everest2003.cz/modules.php?name=Vyucto_storna&file=download&hash=L093OWNBY0FUM3lMd0hVQW5iMTlOdz09&id=4336",
        "Status": "OK"
    }
}
```

### Příloha: Seznam chybových kódu v ErrorResponse

| Číslo chyby | Popis chyby                                  | Význam                                                                                      |
| ----------- | -------------------------------------------- | ------------------------------------------------------------------------------------------- |
| 1           | Unknown Status.                              | Neznámý status.                                                                             |
| 2           | UserKey error.                               | Chyba v UserKey.                                                                            |
| 3           | DateFrom error.                              | Chyba v DateFrom.                                                                           |
| 4           | DateTo error.                                | Chyba v DateTo.                                                                             |
| 5           | Unknown InsId.                               | Neznámý InsId.                                                                              |
| 6           | Area error.                                  | Chyba v Area.                                                                               |
| 7           | Passenger X. name missing.                   | Chybí jméno X-té osoby.                                                                     |
| 8           | Passengers count does not match NumPerson.   | Počet cestujících neodpovídá NumPerson.                                                     |
| 9           | Number of passengers not allowed.            | Počet cestujících překročen.                                                                |
| 10          | Database not connected.                      | Databáze není připojena. Opakujte volání.                                                   |
| 11          | Failed loading XML + podrobnější popis chyby | Nepodařilo se načíst XML + podrobnější popis chyby                                          |
| 12          | Error decoding json.                         | Chyba dekódování JSON.                                                                      |
| 13          | No insurance products for this criteria.     | Žádné pojistné produkty neodpovídají kritériím.                                             |
| 14          | InsProduct for person No.X not valid.        | InsProduct za osobu X není platný.                                                          |
| 15          | Missing TourPrice for person No.X            | Chybějící TourPrice na osobu X                                                              |
| 17          | Creditalials not valid.                      | Creditalials není platný. Uživatel s UserKey nemá přístup k WS Everest                      |
| 18          | Unknown user. Authorization failed.          | Neznámý uživatel. Autorizace se nezdařila. Nesprávný UserKey.                               |
| 19          | 0 rows affected.                             | 0 řádků ovlivněno. Operaci nelze provést, zkontrolujte stav objednávky pomocí OrderInfo.    |
| 20          | Accesskey not correct.                       | Accesskey není správné.                                                                     |
| 21          | Email not sent. Missing email address.       | Email není odeslán. Chybí e-mailová adresa.                                                 |
| 22          | Not recognised operation (root element).     | Nerozpoznána operace (neznámý root element). Také je vypisována při nesprávné syntaxi JSON. |
