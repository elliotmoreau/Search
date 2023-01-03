<?php

        if (empty($_GET["q"])) {
          $allarticles = $db->query('SELECT * FROM articles ORDER BY id DESC LIMIT 10');
          $allpodcast = $db->query('SELECT * FROM podcast ORDER BY id DESC LIMIT 10');
          $allsport = $db->query('SELECT * FROM sport ORDER BY id DESC LIMIT 10');
        } else {
          $allarticles = $db->query('SELECT * FROM articles ORDER BY id DESC LIMIT 50');
          $allpodcast = $db->query('SELECT * FROM podcast ORDER BY id DESC LIMIT 50');
          $allsport = $db->query('SELECT * FROM sport ORDER BY id DESC LIMIT 50');
        }


        if (isset($_GET["q"]) and !empty($_GET["q"])) {
          $recherche = htmlspecialchars($_GET["q"]);


          $initialsearch = $recherche;

          function split_words($string)
          {
            $retour = array();
            $delimiteurs = ' .!?, :;(){}[]%';
            $tok = strtok($string, " ");
            while (strlen(join(" ", $retour)) != strlen($string)) {
              array_push($retour, $tok);
              $tok = strtok($delimiteurs);
            }
            return $retour;
          }

          $out = split_words($recherche);;
          $recherche = implode('%" OR "%', $out);
          $recherche = '%' . $recherche . '%';

            // echo 'SELECT * FROM articles WHERE titre LIKE "' . $recherche . '" ORDER BY id DESC';

          $allarticles = $db->query('SELECT * FROM articles WHERE titre LIKE "' . $recherche . '" ORDER BY id DESC');
          $allpodcast = $db->query('SELECT * FROM podcast WHERE titre LIKE "' . $recherche . '" ORDER BY id DESC');
          $allsport = $db->query('SELECT * FROM sport WHERE search LIKE "' . $recherche . '" ORDER BY id DESC');
        }
        ?>

        <br><br>
        <h3><?php

        if ((empty($recherche)) AND $allarticles->RowCount() > 1) {
          echo 'Articles :';
        }elseif (empty($recherche)) {
          echo 'Article :';
        }elseif($allarticles->RowCount() > 1) {
          echo '' . $allarticles->RowCount() . ' Articles :';
        } else {
          echo '' . $allarticles->RowCount() . ' Article :';
        }


      ?> </h3>
      <center>

        <?php
        if ($allarticles->RowCount() > 0) {
          while ($article = $allarticles->fetch()) {
            ?>
            <article class="card bg-dark" style="width: 80%;">
              <a href="../article.php?id=<?php echo $article['id'] ?>">
                <h2 class="results-title"><?php echo $article['titre'] ?></h2>
                <p class="results-content"><?php echo $article['description'] ?></p>
              </a>
            </article>
            <br>
            <?php
          }
        } else {
          ?>
          <article class="card bg-dark" style="width: 80%; height:100px;">
            <h2 style="font-size: 30px;">Aucun article trouvé</h2>
          </article>
          <?php
        }
        ?>
      </center>

      <br><br>
      <h3><?php

      if (empty($recherche) AND $allpodcast->RowCount() > 1) {
        echo 'Podcasts :';
      }elseif (empty($recherche)) {
        echo 'Podcast :';
      }elseif ($allpodcast->RowCount() > 1) {
        echo '' . $allpodcast->RowCount() . ' Podcasts :';
      } else {
        echo '' . $allpodcast->RowCount() . ' Podcast :';
      }


    ?> </h3>
    <center>

      <?php
      if ($allpodcast->RowCount() > 0) {
        while ($podcast = $allpodcast->fetch()) {
          ?>
          <article class="card bg-dark" id="podcast<?= $podcast["id"] ?>">
            <a>
              <p class="sponsor-name"><?= $podcast["titre"] ?></p>
              <audio controls="controls" controlsList="nodownload" preload="none" style="width:95%">
                <source src="../podcast/audios/<?= $podcast["id"] ?>.mp3" type="audio/mpeg" />
                </audio><br>
                <center>
                  <a href="../podcast/audios/download.php?file=<?= $podcast["id"] ?>" class='btn btn-primary download'><i class="fa-solid fa-download"></i> Télecharger</a>
                  <a onclick="integrer(<?= $podcast["id"] ?>)" class='btn btn-primary integrer' id="integrer"><i class="fa-solid fa-code"></i> Intégrer</a>
                  <!-- Ici faire un bouton pour intégrer le podcast a un site avec iframe :  -->
                </center>
              </a>
            </article>
            <br>
            <?php
          }
        } else {
          ?>
          <article class="card bg-dark" style="width: 80%; height:100px;">
            <h2 style="font-size: 30px;">Aucun podcast trouvé</h2>
          </article>
          <?php
        }
        ?>
        
      </center>
      
      <br><br>
      <h3><?php

      if (empty($recherche) AND $allsport->RowCount() > 1) {
        echo 'Sports :';
      }elseif (empty($recherche)) {
        echo 'Sport :';
      }elseif ($allsport->RowCount() > 1) {
        echo '' . $allsport->RowCount() . ' Sports :';
      } else {
        echo '' . $allsport->RowCount() . ' Sport :';
      }


    ?> </h3>
    <center>

      <?php
      if ($allsport->RowCount() > 0) {
        while ($sport = $allsport->fetch()) {
          ?>
          
          <article class="card bg-dark" style="background: linear-gradient(90deg, <?= $sport["color"] ?> 0%, <?= $sport["secondary_color"] ?> 100%);">
            <!-- style="background-color: -->
            <a>
              <p class="sponsor-name"><?= $sport["winner"] ?> - <?= $sport["looser"] ?></p>
              <p><?= $sport["Date"] ?></p>
              <p><?= $sport["sport"] ?> <?= $sport["evenement"] ?></p>
              <p><?= $sport["score_winner"] ?> - <?= $sport["score_looser"] ?></p>
            </a>
          </article>
          <br>
          
          <?php
        }
      } else {
        ?>
        <article class="card bg-dark" style="width: 80%; height:100px;">
          <h2 style="font-size: 30px;">Aucun sport trouvé</h2>
        </article>
        <?php
      }
      ?>
