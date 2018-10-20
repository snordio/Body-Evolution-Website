<?php
	require_once('config.php');
    require_once('printHeader.php');
    $foot = file_get_contents("../Templates/footer.txt");
	$logout = "<a id=\"logoutButton\" title=\"Effettua il logout\" href=\"logout.php\"><span lang=\"en\">Logout</span></a>";
	$login = "<a id=\"panelButton\" title=\"Effettua il login\" href=\"areaPersonale.php\">Area Personale</a>";
	$adminPanel = "<a id=\"panelButton\" title=\"Vai al pannello amministratore\" href=\"adminPanel.php\"><span lang=\"en\">Admin Panel</span></a>";
	$userPanel = "<a id=\"panelButton\" title=\"Vai al pannello utente\" href=\"userPanel.php\"><span lang=\"en\">User Panel</span></a>";
	$closediv = "</div>";
	$closebody = "</body>";
	$closehtml = "</html>";

    $query=query("
		SELECT NomeImmagine, Album 
		FROM galleria 
		GROUP BY Album, NomeImmagine;
	");

    printHead('Galleria');
	if(isset($_SESSION['user_code']) && $_SESSION['user_type'] == 'admin') {
		echo $logout;
		echo $adminPanel;
	} else if(isset($_SESSION['user_code']) && $_SESSION['user_type'] == 'user') {
		echo $logout;
		echo $userPanel;
	} else {
		echo $login;
	}
	
	echo $closediv;
	echo $closediv;
	$title = "<div id=\"corpo\">
				<div id=\"Presentazione\">
					<h1 id=\"titoloPagina\">GALLERIA ALBUM</h1>
					<p>Guarda le foto scattate dai nostri Trainer qui alla <span lang=\"en\">Body Evolution</span>!</p>
				</div>";
	echo $title;	

    $opendiv = "<div class=\"gallerymain\">";
    echo $opendiv;

    $aux=null; $stampa=null;
    while($row = mysqli_fetch_assoc($query))
            {   
                
                if($aux==null)//caso in cui siamo appena entrati a prelevare nel database
                    {
                    $stampa = "<a href=\"albumGalleria.php?album=".$row['Album']."\"><div class=\"album\"> <h2 class=\"albumname\">".$row['Album']."</h2><img class=\"galleryimg\" src=\"../Uploads/upGalleria/".$row['Album'].'/'.$row['NomeImmagine']."\" alt=\"Immagine dell'album ".$row['Album']."\"></div></a>";
                    // aggiungere il primo $row di ogni album
                        $aux=$row['Album'];
                    }
                else if($row['Album']!=$aux)
                {
                    echo $stampa;
                    $stampa="<a href=\"albumGalleria.php?album=".$row['Album']."\"><div class=\"album\"> <h2 class=\"albumname\">".$row['Album']."</h2><img class=\"galleryimg\" src=\"../Uploads/upGalleria/".$row['Album'].'/'.$row['NomeImmagine']."\" alt=\"Immagine dell'album ".$row['Album']."\"/></div></a>";
                    $aux=$row['Album'];
                }
            
                
            }
            
    echo $stampa;
    echo $closediv;
	echo $closediv;
	close_connection();
    echo $foot;
	echo $closebody;
	echo $closehtml;
?>