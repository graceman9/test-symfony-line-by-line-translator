Requirements:
* read data from a local file
* translate the strings in the file
* save the results to another file.
* Each line in the input file contains one string that needs to be translated.
* handle very large files efficiently.
* mock translation logic
* Add support for multiple translators, allowing the user to choose which translator to use.
* submit your code as Git repository

Usage:
1) clone repository
2) `cd test-symfony-line-by-line-translator`
3) `docker compose up -d`
4) `docker compose exec php composer install`
5) `mkdir app/var/data-to-translate`
6) copy some file to `app/var/data-to-translate/`, i.e. `cp path/to/file.txt app/var/data-to-translate/file.txt`
7) run app:translate-file, i.e. `docker compose exec php bin/console app:translate-file file.txt`
8) as the result you will see the following message: ` [OK] Document translated successfully using App\Service\Translator\SimpleTranslator translator, document = file.txt`, translation will be saved to `app/var/data-to-translate/translation/file.txt`

You can also specify any path relative to `app/var/data-to-translate/` folder like that: 
`docker compose exec php bin/console app:translate-file file.txt my/custom/path/result.txt`

You will see different prefix appended to the lines (instead of translation, because it's mocked):
- `'Translation by SimpleTranslator: '` for `App\Service\Translator\SimpleTranslator`
- `'Translation by AlmostRealTranslator: '` for `App\Service\Translator\AlmostRealTranslator`

There is always room for improvement, but this should be sufficient according to the requirements.