<?php
    $tags = "Sez. 6 – Lingue e Letterature. Teatro";

    $catalogTextToParse = "Alfieri Vittorio – Tragedie, Avignone 1818
Bacigalupo Nicolò –  I maneggi per maritare una figlia, Milano 2004
Baijni Sandro – Amleto & compagni all’ombra del Duomo. Venti monologhi di Shakespeare in lingua milanese, Milano 2002
Baijni Sandro – Teatro e Poetiche, il settecento in Inghilterra e in Francia, Milano 2007
Bajini Sandro – Considerazioni sul comico. Il paradosso teatrale, a cura di M. Innocenti, Sanremo 2014
Björnson Björnstierne – Drammi e racconti, Milano 1964
Björnson Björnstjerne – Drammi: I° Al di là delle nostre forze. II° Quando fiorisce il vino buono
Carli Franco – Amanuense, Ventimiglia 2012
D’Annunzio Gabriele – La figlia di Iorio, s.l. 1939
D'Amico Silvio – Storia del Teatro Drammatico, 4 voll., Roma 1939/40
D'Annunzio Gabriele – La figlia di Iorio, Roma 1995
de Milosz Oscar Vladislas – Teatro, Milano 1977
Ervino Pocar, Torino 1931
Fiaschini Fabrizio – L’«incessabil agitazione». Giovan Battista Andreini tra professione teatrale, cultura letteraria e religione, Pisa 2007
Foscolo Ugo – Tragedie e poesie, Milano 1880
Goldoni Carlo – Commedie, Milano 1959
Ionesco Eugéne – La ricerca intermittente, Parma 1989
Lopez Sabatino (a cura di) – Tutto Gilberto Govi, vol. 1, Milano 2004 
Manzoni Alessandro – Adelchi, a cura di G. Davico Bonino, Torino 2009
Molière – Commedie, Milano 1960
Pessoa Fernando – L'Enigma e le Maschere, Faenza 1996
Pietro Aretino– La Talanta, Milano 1956
Rostand Edmond – Cirano di Bergerac, Roma 1993
Ruffini Franco – Commedia e festa nel Rinascimento. La “Calandria” alla corte di Urbino, Bologna 1986
Schiller Federico – Maria, Milano 1950
Schiller Friedrich – La sposa di Messina, s.l. 1830
Shakespeare William  – Otello, Torino 1953
Shakespeare William – Amleto, Milano 2003
Shakespeare William – Antonio e Cleopatra, Milano 2003
Shakespeare William – Come vi garba, Milano 1950
Shakespeare William – Giulio Cesare, Milano 2003
Shakespeare William – La bisbetica domata, Milano 2003
Shakespeare William – La dodicesima notte, Milano 2003
Shakespeare William – La tempesta, Milano 2003
Shakespeare William – Le allegre comari di Windsor, Milano 2003
Shakespeare William – Macbeth, Milano 1951
Shakespeare William – Macbeth, Milano 2003
Shakespeare William – Molto strepito per nulla, Milano 2003
Shakespeare William – Sidorchik, Milano 1955
Shakespeare William – Otello, Milano 2003
Shakespeare William – Re Lear, Milano 2003
Shakespeare William – Riccardo II, Milano 2003
Shakespeare William – Riccardo III, Milano 2003
Shakespeare William – Romeo e Giulietta, Milano 2003
Shakespeare William – Romeo e Giulietta, Roma 1990
Shakespeare William – Romeo e Giulietta-Amleto-Otello, Roma 1997
Shakespeare William – Sogno di una notte d’estate, Milano 1950
Shakespeare William – Sogno di una notte di mezza estate, Milano 2003
Shakespeare William – Sogno, Amleto, Milano 1951
Shakespeare William – Teatro completo. Vol. 2: Le commedie romantiche, Milano 1982
Tasso Torquato – Intrichi d’amore, comedia, Roma 1978";



    require 'functions.php';

    $ini = parse_ini_file('../app.ini', true);

    $link = mysqli_connect($ini[database][host], $ini[database][user], $ini[database][password], $ini[database][name]) or die('Ошибка');
    mysqli_set_charset($link, 'utf8');

    $linesArray = explode("\n", $catalogTextToParse);
    $books = [];

    foreach($linesArray as $line) {
        $book = [];

        //  If no author
        if (strpos($line, '–') !== false) {
            $authorAndOther = explode('–', $line);
            $book['author'] = trim(str_replace("'", "\'", $authorAndOther[0]));

            if (strpos($book['author'], ' (a cura di)') !== false) {
                $book['author'] = str_replace(' (a cura di)', '', $book['author']);
            }

            if (strpos($book['author'], 'AA.VV.') !== false) {
                $book['author'] = str_replace('AA.VV.', 'AA. VV.', $book['author']);
            }

            $book['author'] = typograf($book['author']);
            $line = $authorAndOther[1];
        }

        $titleAndOther = explode(', ', $line);

        for ($i = 0; $i < count($titleAndOther) - 1; $i++) {
            if ($i > 0)
                $book['title'] .= ', ';

            $book['title'] .= $titleAndOther[$i];
        }
        $book['title'] = typograf(trim(str_replace("'", "\'", $book['title'])));

        $book['publishing'] = trim(array_pop($titleAndOther));

        if (strpos($book['publishing'], ' s.l. ') !== false) {
            $book['publishing'] = str_replace(' s.l. ', '', $book['publishing']);
        }
        if (strpos($book['publishing'], ' s. l. ') !== false) {
            $book['publishing'] = str_replace(' s. l. ', '', $book['publishing']);
        }
        if (strpos($book['publishing'], 's.l. ') !== false) {
            $book['publishing'] = str_replace('s.l. ', '', $book['publishing']);
        }
        if (strpos($book['publishing'], 's. l. ') !== false) {
            $book['publishing'] = str_replace('s. l. ', '', $book['publishing']);
        }

        if (strpos($book['publishing'], ' s.d.') !== false) {
            $book['publishing'] = str_replace(' s.d.', '', $book['publishing']);
        }
        if (strpos($book['publishing'], 's.d.') !== false) {
            $book['publishing'] = str_replace('s.d.', '', $book['publishing']);
        }

        if (strpos($book['publishing'], ' [ma') !== false) {
            $book['publishing'] = str_replace(' [ma', '', $book['publishing']);
            $book['publishing'] = str_replace(']', '', $book['publishing']);
        }

        if (strpos($book['publishing'], ' 1') !== false || strpos($book['publishing'], ' 2') !== false) {
            if (strpos($book['publishing'], ' 1') !== false) {
                $book['publishing'] = str_replace(' 1', ', 1', $book['publishing']);
            }
            else {
                $book['publishing'] = str_replace(' 2', ', 2', $book['publishing']);
            }
        }

        $books[] = $book;

        // Adding to DB
        mysqli_query($link, "INSERT INTO catalogue (id, title, author, publishing, price, monthBook, description, tags) VALUES (NULL, '$book[title]', '$book[author]', '$book[publishing]', '$price', '$monthBook', '$description', '$tags')");
    }

    echo '<code lang="php">';
    print_r($books);
    echo '</code>';