# Test Assignment

## Zadanie
W dowolnie wybranym przez siebie frameworku PHP lub w czystym PHP napisz aplikacje, która spełni poniższe wymagania. Najlepiej z wykorzystaniem OOP

1. Na stronie głównej jest dostępny formularz z polami: Imie, Nazwisko, Plik.
2. Formularz asynchronicznie wyślij na serwer (po kliknięciu w przycisk Wyślij) i zapisz wszystkie dane. Po prawidłowym zapisaniu wyświetl komunikat o powodzeniu lub ewentualnym błędzie wraz z kodem błedu.
3. Zrób walidacje danych, tak żeby imie nie mogło być puste, a plik był dopuszczony tylko w formacie jpg, jpeg i png.
4. Utwórz stronę, na której wyświetlisz zebrane dane w tabeli. Plik ma być dostepny pod linkiem.
5. Stronę z danymi zabezpiecz wybraną przez siebie metodą, tak żeby mógł się tam dostać tylko ktoś kto zna login i hasło.

## Server requirements

- PHP8 with SQLite extension
- Symfony 5
- yarn

## Build

Run commands from the project root directory 
```shell
php composer.phar install
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
yarn install
yarn encore dev
symfony server:start
```
## Content
1. Client registration form on the Homepage `/`
2. Rest api documentation `/api/doc`
3. Protected admin webpage with the data received from the registration form `/admin`. Default credentials: `admin`/`123`
