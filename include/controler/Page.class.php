<?php

class Page
{
    public function __construct(
        private string $template = "",
        private string $nav = "",
        private string $header = "",
        private string $footer = "",
        private string $vue = "",
        private string $title = "",
        private string $page = ""
    ) {
        //var_dump($this->page);
        // $this->generateView();
    }

    private function generateView()
    {
        $this->template = file_get_contents("../include/view/template.view.php");
        $this->nav = file_get_contents("../include/view/nav.view.php");
        $this->header = file_get_contents("../include/view/header.view.php");
        $this->footer = file_get_contents("../include/view/footer.view.php");

        $this->vue = str_replace("[[nav]]", $this->nav, $this->template);
        $this->vue = str_replace("[[header]]", $this->header, $this->vue);
        $this->vue = str_replace("[[footer]]", $this->footer, $this->vue);

        $page = "../include/view/" . strtolower($this->page) . ".view.php";
        if (file_exists($page)) {
            $v = file_get_contents($page);
        } else {
            $v = file_get_contents("../include/view/accueil.view.php");
            $this->page = "accueil";
        }
        $this->vue = str_replace("[[title]]", $this->title, $this->vue);
        $this->vue = str_replace("[[page]]", $v, $this->vue);
        switch ($this->page) {
            case 'value':
                # code...
                break;

            default:
                # code...
                //echo "test";
                $this->vue = str_replace("[[AllPropositions]]", $this->Accueil(), $this->vue);
                break;
        }
    }

    public function __toString()
    {
        $this->generateView();
        return $this->vue;
    }

    public function Accueil()
    {
        $cats = Categorie::all();
        $content = "";
        $viewProps = file_get_contents("../include/view/propositions.view.php");
        foreach ($cats as $cat) {
            $content .= "<h1>" . $cat->categorie_nom . "</h1>";
            $props = Proposition::getByCategorie($cat->categorie_ID);
            foreach ($props as $prop) {
                // var_dump($prop->proposition_titre);
                $tmp = "";
                $tmp = str_replace("[[proposition_ID]]", $prop->proposition_ID, $viewProps);
                $tmp = str_replace("[[proposition_titre]]", $prop->proposition_titre, $tmp);
                $tmp = str_replace("[[proposition_description]]", $prop->proposition_description, $tmp);
                // var_dump($tmp);
                $tmp = str_replace("[[villageois]]", $prop->villageois()->villageois_EMAIL, $tmp);
                $tmp = str_replace("[[periode]]", $prop->periode()->periode_date_debut, $tmp);
                $content .= $tmp . "\n";
            }

            if (empty($content)) {
                $content = '<div class="post-preview">Aucune proposition à afficher</div>';
            }
        }


        return $content;
    }
}
