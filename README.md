# A "Nurse Scheduling Problem" 
Egy összetett probléma, amely a nővérek munkaidejének hatékony ütemezésével foglalkozik egészségügyi intézményekben. Célja, hogy minimalizálja a költségeket, elkerülje a túlterhelést és megfelelő betegellátást biztosítson.

## Használat

Látogass el a [https://angolszavaktanulas.hu][1] címre.
  
[1]: https://angolszavaktanulas.hu/

## A műszakbeosztásnak számos kritériuma van

### Szabadságnapok
  
Általában havonta 8 - 10 napot engedélyez a munkaadó.

### Szabadságnapok :
  Általában havonta 8 - 10 napot engedélyez a munkaadó.

### Betegszabadságnapok
### Kérések
 Általában 4 - 5 kérést engedélyez a munkáltató, mert meg kell maradni a megfelelő létszámnak a beosztáshoz.

### Pihenő napok:
- A dolgozó 1 napot is dolgozhat szabadnapot megelőzően (nappal – pihenő, éjszaka – pihenő) 

- 2 munkanapot dolgozhat két egymást követő napon a szabadnapot megelőzően (nappal - nappal – pihenő, éjszaka – éjszaka – pihenő, vagy nappal - éjszaka - pihenő), 

- 3 munkanapot dolgozhat szabadnapot követően (nappal – nappal - éjszaka vagy nappal – éjszaka – éjszaka).

- Általában havi 14 műszak: Javarészt 7 nap nappal, 6 nap éjszaka szokott lenni. Mivel folyamatos munkarend van, ezért előfordulhat kevesebb műszak, mert fél éves időintervallumban szükséges az óraszám letöltése. Ez azért lehet így, mert folyamatos munkarendnél 12 órás műszakok vannak, ami nem fogja azt a negyven órás munkahetet egy hónapba visszaadni. Mindig a ledolgozandó óraszám szükséges 40 órás munkahéttel számolva (a ledolgozandó napok számától függ, lehet 20 nap 160 óra, lehet 21nap 168 óra, 22 nap 176 óra, 23 nap 184 óra). Ezeket az óraszámokat rövidítheti egy – egy ünnep ami, 8 órával levonódik. A főnővér vonja le minden nővértől, illetve gondozótól az adott hónap óraszámából. Ebből is látszik, hogy ezért adnak bizonyos időintervallumokat, hogy minden dolgozónak kijöjjön a megfelelő óraszám. A plusz és mínusz órákat így lehet kiegyenlíteni az időszak végére.


### A műszakbeosztáshoz tartozó algoritmus célja 
A kritériumokat figyelembe véve olyan beosztást állítson össze, ami minden nővér számára egységesen optimális, és próbálja elkerülni, hogy néhány nővér túlzott terhelés alá kerüljön. Egy példa: olyan munkarendet készítsen, ahol elkerüli, hogy egy alkalmazott a hónap első felében nagyobb terhelést kapjon, majd a második felében kevesebbet dolgozzon.

### Az algoritmus működését összefoglalva
Tapasztalataim szerint az egyszerű hagyományos genetikus algoritmus (GA) hosszú futási időt igényelt az optimális megoldás konzisztens eléréséhez. 
A fentiek eredményeként saját 'hibrid' algoritmust dolgoztam ki az ütemezés terén. Ez a speciális algoritmus rövidebb futási idő mellett képes az optimális beosztás kialakítására.
Legfontosabb változtatás a rövidebb futási idő érdekében, ha már a kezdetleges populációban az első beosztást  a legnagyobb kockázattal rendelkező egyed kapja meg. Vegyük példának azt az esetet, amikor egy dolgozó fél hónapig nem tud dolgozni. Ebben az esetben a kockázat számítás alapján az adott dolgozóhoz egy „kockázati” érték kerül rendelésre, illetve előre kiszámolt óra szám szerint rendel hozzá nappalt és éjszakai beosztást. Ezenfelül előre kiszámított óraszám alapján kerülnek meghatározásra a nappali és éjszakai műszakok az adott dolgozó beosztásában. 

### Webalkalmazás további funkciói rövid leírása

**Autentikáció:**
Az alkalmazás autentikációs rendszere gondoskodik arról, hogy minden felhasználó megfelelő szerepkörhöz legyen hozzárendelve, például főnővér vagy nővér, és lehetővé teszi számukra a megfelelő csoporthoz csatlakozni, hogy a megfelelő beosztást kapja meg.
	
**Főnővér hitelesítés utáni felület** 
Ezen a felületen a felhasználó megtekintheti a dolgozók havi munkarendjét és pihenőnapjait. A felület számos további hasznos funkciót kínál, például a beosztás kézi módosítását, mentését, vagy törlését, továbbá az automatikus beosztás generálását. Lehetőség van dolgozók regisztrálására is. Ezen kívül elérhetővé válnak a beállítások, ahol a felhasználó különböző megszorításokat alkothat a dolgozók számára, valamint finomhangolhatja a beosztás készítő algoritmust.


**Nővér hitelesítés utáni felület**
 Ezen a felületen a felhasználó megtekintheti saját beosztását, és lehetősége van szabadság, betegszabadság vagy pihenőnap jelölésére azon napokra, amelyeken nem tud dolgozni."







