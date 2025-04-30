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
4. Všechny metody v případě chyby nebo nesprávně zadaných budou vracet **ErrorResponse**. V případě úspěšného zpracování bude vrácen **Response** jak je popsáno v časti popis metod. 
5.	Interaktivní tester naleznete na https://ws.everest2003.cz/tester.php



## Typy pojištění a jejich obsah

Na základě smlouvy s pojišťovnou je provozovatelem zpřístupněné produkty dané pojišťovny. V současné době jsou dostupné tyto sady:

- UNIQA pojišťovna, a.s. 
- Generali Česká pojišťovna a.s. 
- INTER PARTNER ASSISTANCE S. A.

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

|Zkratka|InsProdukt |InsType|Poznámka|
|-      |-          |-      |-   |
|nD5S    |D5S         |t      | pouze ČR|
|nD5S+   |D5S         |zs     ||
|nK5    |K5         |t      ||
|nK5+   |K5         |zs     ||
|nK10    |K10         |t      ||
|nK10+   |K10         |zs     ||
|nK15    |K15         |t      ||
|nK15+   |K15         |zs     ||
  
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

| Zkratka | InsProdukt | InsType | Poznámka       |
|---------|------------|---------|----------------|
| nD5S    | D5S        | t       | pouze pro ČR   |
| nD5S+   | D5S        | zs      | pouze pro ČR   |
| nIK5    | IK5        | t       |                |
| nIK5+   | IK5        | zs      |                |
| nIK10   | IK10       | t       |                |
| nIK10+  | IK10       | zs      |                |
| nIK15   | IK15       | t       |                |
| nIK15+  | IK15       | zs      |                |

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
   
  | Zkratka              | InsProduct | CancProduct | Poznámka |
  |----------------------|------------|-------------|----------|
  | Rozsah09            | Rozsah09   | -           |          |
  | Rozsah10            | Rozsah10   | -           |          |
  | Rozsah09 + Rozsah04 | Rozsah09   | Rozsah04    |          |
  | Rozsah09 + Rozsah05 | Rozsah09   | Rozsah05    |          |
  | Rozsah09 + Rozsah06 | Rozsah09   | Rozsah06    |          |
  | Rozsah10 + Rozsah04 | Rozsah10   | Rozsah04    |          |
  | Rozsah10 + Rozsah05 | Rozsah10   | Rozsah05    |          |
  | Rozsah10 + Rozsah06 | Rozsah10   | Rozsah06    |          |
  | Rozsah35            | Rozsah35   | -           |          |
  | Rozsah36            | Rozsah36   | -           |          |
  | Rozsah37            | Rozsah37   | -           |          |
  | Rozsah09 + Rozsah14 | Rozsah09   | Rozsah14    |          |
  | Rozsah09 + Rozsah15 | Rozsah09   | Rozsah15    |          |
  | Rozsah09 + Rozsah16 | Rozsah09   | Rozsah16    |          |
  | Rozsah10 + Rozsah14 | Rozsah10   | Rozsah14    |          |
  | Rozsah10 + Rozsah15 | Rozsah10   | Rozsah15    |          |
  | Rozsah10 + Rozsah16 | Rozsah10   | Rozsah16    |          |
  | Rozsah11            | Rozsah11   | -           |          |
  | Rozsah12            | Rozsah12   | -           |          |
  | Rozsah13            | Rozsah13   | -           |          |

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

| Zkratka  | InsProduct | Poznámka |
|----------|------------|----------|
| Rozsah07 | Rozsah07   |          |
| Rozsah08 | Rozsah08   |          |
| Rozsah11 | Rozsah11   |          |
| Rozsah12 | Rozsah12   |          |
| Rozsah13 | Rozsah13   |          |
| Rozsah14 | Rozsah14   |          |
| Rozsah15 | Rozsah15   |          |
| Rozsah16 | Rozsah16   |          |
| Rozsah35 | Rozsah35   |          |
| Rozsah36 | Rozsah36   |          |
| Rozsah37 | Rozsah37   |          |
| Rozsah41 | Rozsah41   |          |
| Rozsah42 | Rozsah42   |          |
| Rozsah43 | Rozsah43   |          |
| Rozsah44 | Rozsah44   |          |
| Rozsah45 | Rozsah45   |          |
| Rozsah46 | Rozsah46   |          |

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

| Zkratka    | InsProduct | Poznámka       |
|------------|------------|----------------|
| Rozsah17   | Rozsah17   | -              |
| Rozsah18   | Rozsah18   | -              |
| Rozsah19   | Rozsah19   | -              |
| Rozsah20   | Rozsah20   | -              |
| Rozsah21   | Rozsah21   | -              |
| Rozsah22   | Rozsah22   | -              |
| Rozsah23   | Rozsah23   | -              |
| Rozsah24   | Rozsah24   | -              |
| Rozsah25   | Rozsah25   | -              |
| Rozsah26   | Rozsah26   | -              |
| Rozsah27   | Rozsah27   | -              |
| Rozsah28   | Rozsah28   | -              |

### INTER PARTNER ASSISTANCE S. A. (AXA)

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

### Dotaz na získání ceny bez uložení záznamu (`[InsuranceOrder]`)

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

#### Příklad dotazu na získání ceny bez uložení záznamu

```json
{
  "UserKey": "41059e28e30af11f62473ee29a93b2e1",
  "OrderId": "20141010",
  "DateFrom": "10.10.2025",
  "DateTo": "15.10.2025",
  "NumPerson": 2,
  "Area": "E",
  "InsId": "W",
  "InsType": "t",
  "CancValue": 50,
  "TourPrice": 20000.0,
  "Currency": "CZK",
  "Email": "vir2al3vel@gmail.com",
  "Ticketing": "A",
  "Status": "K"
}

```





