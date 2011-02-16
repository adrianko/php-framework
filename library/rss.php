<?php

class RSS {

    public $channel;
    public $items;

    public function header() {
        header("Content-Type: application/rss+xml; charset=ISO-8859-1");
    }

    public function build() {
        $rss = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
        $rss .= "<rss version=\"2.0\">";
        $rss .= "<channel>";
        $rss .= "<title>".$this->channel->title."</title>";
        $rss .= "<link>".$this->channel->link."</link>";
        $rss .= "<description>".$this->channel->description."</description>";
        foreach($this->items as $item) {
            $rss .= $this->item($item);
        }
        $rss .= "</channel>";
        $rss .= "</rss>";
    }

    public function item($item) {
        $rss = "<item>";
        if(isset($item->title)) {
            $rss .= "<title>".$item->title."</title>";
        }
        if(isset($item->time)) {
            $rss .= "<pubDate>".date('r', $item->time)."</pubDate>";
        }
        if(isset($item->description)) {
            $rss .= "<description>".$item->description."</description>";
        }
        if(isset($item->author)) {
            $rss .= "<author>".$item->author."</author>";
        }
        if(isset($item->link)) {
            $rss .= "<link>http://".$_SERVER['SERVER_NAME'].$item->link."</link>";
        }
        if(isset($item->category)) {
            foreach($item->category as $category) {
                $rss .= "<category>".$category."</category>";
            }
        }
        if(isset($item->id)) {
            $rss .= "<guid>http://".$_SERVER['SERVER_NAME']."/rss/item".$item->id."</guid>";
        }
        $rss .= "</item>";
        return $rss;
    }

}

?>
