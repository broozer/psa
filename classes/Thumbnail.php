<?php

/**
* [name] Thumbnail.php
* [type] file
* [package] classes
* [since] 2009-05-23
* [update]
* [author] Wim Paulussen
* [creation-by] pcb.php (version: 0.3 - 2008-12-21)
*/

/**
* [name] Thumbnail
* [type] class
*/
class Thumbnail
{
    /**
    * [name] mawWidth
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $mawWidth;
    /**
    * [name] maxHeight
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $maxHeight;
    /**
    * [name] scale
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $scale;
    /**
    * [name] inflate
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $inflate;
    /**
    * [name] types
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $types;
    /**
    * [name] imgLoaders
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $imgLoaders;
    /**
    * [name] imgCreators
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $imgCreators;
    /**
    * [name] source
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $source;
    /**
    * [name] sourceWidth
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $sourceWidth;
    /**
    * [name] sourceHeight
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $sourceHeight;
    /**
    * [name] thumb
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $thumb;
    /**
    * [name] thumbWidth
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $thumbWidth;
    /**
    * [name] thumbHeight
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $thumbHeight;
    /**
    * [name] sourceMime
    * [type] attribute
    * [scope] private
    * [expl]
    */
    private $sourceMime; 
    
    /**
    * [name] setMawWidth
    * [type] method
    * [scope] public
    * [expl] set mawWidth
    */
    public function setMawWidth($data) { $this->mawWidth = $data; }
    /**
    * [name] setMaxHeight
    * [type] method
    * [scope] public
    * [expl] set maxHeight
    */
    public function setMaxHeight($data) { $this->maxHeight = $data; }
    /**
    * [name] setScale
    * [type] method
    * [scope] public
    * [expl] set scale
    */
    public function setScale($data) { $this->scale = $data; }
    /**
    * [name] setInflate
    * [type] method
    * [scope] public
    * [expl] set inflate
    */
    public function setInflate($data) { $this->inflate = $data; }
    /**
    * [name] setTypes
    * [type] method
    * [scope] public
    * [expl] set types
    */
    public function setTypes($data) { $this->types = $data; }
    /**
    * [name] setImgLoaders
    * [type] method
    * [scope] public
    * [expl] set imgLoaders
    */
    public function setImgLoaders($data) { $this->imgLoaders = $data; }
    /**
    * [name] setImgCreators
    * [type] method
    * [scope] public
    * [expl] set imgCreators
    */
    public function setImgCreators($data) { $this->imgCreators = $data; }
    /**
    * [name] setSource
    * [type] method
    * [scope] public
    * [expl] set source
    */
    public function setSource($data) { $this->source = $data; }
    /**
    * [name] setSourceWidth
    * [type] method
    * [scope] public
    * [expl] set sourceWidth
    */
    public function setSourceWidth($data) { $this->sourceWidth = $data; }
    /**
    * [name] setSourceHeight
    * [type] method
    * [scope] public
    * [expl] set sourceHeight
    */
    public function setSourceHeight($data) { $this->sourceHeight = $data; }
    /**
    * [name] setThumb
    * [type] method
    * [scope] public
    * [expl] set thumb
    */
    public function setThumb($data) { $this->thumb = $data; }
    /**
    * [name] setThumbWidth
    * [type] method
    * [scope] public
    * [expl] set thumbWidth
    */
    public function setThumbWidth($data) { $this->thumbWidth = $data; }
    /**
    * [name] setThumbHeight
    * [type] method
    * [scope] public
    * [expl] set thumbHeight
    */
    public function setThumbHeight($data) { $this->thumbHeight = $data; }
    /**
    * [name] setSourceMime
    * [type] method
    * [scope] public
    * [expl] set sourceMime
    */
    public function setSourceMime($data) { $this->sourceMime = $data; }

    /**
    * [name] getMawWidth
    * [type] method
    * [scope] private
    * [expl] get mawWidth
    */
    private function getMawWidth() { return $this->mawWidth; }
    /**
    * [name] getMaxHeight
    * [type] method
    * [scope] private
    * [expl] get maxHeight
    */
    private function getMaxHeight() { return $this->maxHeight; }
    /**
    * [name] getScale
    * [type] method
    * [scope] private
    * [expl] get scale
    */
    private function getScale() { return $this->scale; }
    /**
    * [name] getInflate
    * [type] method
    * [scope] private
    * [expl] get inflate
    */
    private function getInflate() { return $this->inflate; }
    /**
    * [name] getTypes
    * [type] method
    * [scope] private
    * [expl] get types
    */
    private function getTypes() { return $this->types; }
    /**
    * [name] getImgLoaders
    * [type] method
    * [scope] private
    * [expl] get imgLoaders
    */
    private function getImgLoaders() { return $this->imgLoaders; }
    /**
    * [name] getImgCreators
    * [type] method
    * [scope] private
    * [expl] get imgCreators
    */
    private function getImgCreators() { return $this->imgCreators; }
    /**
    * [name] getSource
    * [type] method
    * [scope] private
    * [expl] get source
    */
    private function getSource() { return $this->source; }
    /**
    * [name] getSourceWidth
    * [type] method
    * [scope] private
    * [expl] get sourceWidth
    */
    private function getSourceWidth() { return $this->sourceWidth; }
    /**
    * [name] getSourceHeight
    * [type] method
    * [scope] private
    * [expl] get sourceHeight
    */
    private function getSourceHeight() { return $this->sourceHeight; }
    /**
    * [name] getThumb
    * [type] method
    * [scope] private
    * [expl] get thumb
    */
    private function getThumb() { return $this->thumb; }
    /**
    * [name] getThumbWidth
    * [type] method
    * [scope] private
    * [expl] get thumbWidth
    */
    public function getThumbWidth() { return $this->thumbWidth; }
    /**
    * [name] getThumbHeight
    * [type] method
    * [scope] private
    * [expl] get thumbHeight
    */
    public function getThumbHeight() { return $this->thumbHeight; }
    /**
    * [name] getSourceMime
    * [type] method
    * [scope] private
    * [expl] get sourceMime
    */
    private function getSourceMime() { return $this->sourceMime; }
    
    /**
    * [name] __construct
    * [type] method
    * [scope] public
    * [expl]
    */
    public function __construct($maxWidth,$maxHeight,$scale=true,$inflate=true)
    {
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->scale = $scale;
        $this->inflate = $inflate;
        
        $this->types = array('image/jpeg','image/png','iamge/gif');
        $this->imgLoaders = array(
            'image/jpeg' => 'imagecreatefromjpeg',
            'image/png' => 'imagecreatefrompng',
            'image/gif' => 'imagecreatefromgif'
        );
        $this->imgCreators = array(
            'image/jpeg' => 'imagejpeg',
            'image/png' => 'imagepng',
            'image/gif' => 'imagegif'
        );
        /* DEBUG
        echo 'constr : maxWidth : '.$this->maxWidth.'<br />';
        echo 'constr : maxHeight : '.$this->maxHeight.'<br />';
        */
    }
    /**
    * [name] loadFile
    * [type] method
    * [scope] public
    * [expl]
    */
    public function loadFile($image)
    {
        if(!$dims = @getimagesize($image))
        {
            throw new ThumbnailFileException('Could not find image : '.$image);
        }
        if(in_array($dims['mime'],$this->types))
        {
            $loader = $this->imgLoaders[$dims['mime']];
            $this->source = $loader($image);
            $this->sourceWidth = $dims[0];
            $this->sourceHeight = $dims[1];
            $this->sourceMime = $dims['mime'];
            $this->initThumb();
            return true;
        }
        else
        {
            throw new ThumbnailNotSupportedException('Image MIME type '.$dims['mime'].' not supported');
        }
    }
    /**
    * [name] loadData
    * [type] method
    * [scope] public
    * [expl]
    */
    public function loadData($image,$mime)
    {
        if(in_array($mime,$this->types))
        {
            if($this->source = @imagecreatefromstring($image))
            {
                $this->sourceWidth = imagesx($this->source);
                $this->sourceHeight = imagesy($this->source);
                $this->sourceMime = $mime;
                $this->initthumb();
                return true;
            }
            else
            {
                throw new ThumbnailFileException('Could not load image from string');
            }
        }
        else
        {
            throw new ThumbnailNotSupportedException('Image MIME type '.$mime.' not supported');
        }
    }
    /**
    * [name] buildThumb
    * [type] method
    * [scope] public
    * [expl]
    */
    public function buildThumb($file = null)
    {
        $creator = $this->imgCreators[$this->sourceMime];
        if(isset($file))
        {
            return $creator($this->thumb,$file);
        }
        else
        {
            return $creator($this->thumb);
        }
    }
    /**
    * [name] getMime
    * [type] method
    * [scope] public
    * [expl]
    */
    public function getMime()
    {
        return $this->sourceMime;
    }
    /**
    * [name] initThumb
    * [type] method
    * [scope] private
    * [expl]
    */
    private function initThumb()
    {
        if($this->scale)
        {
            if($this->sourceWidth > $this->sourceHeight)
            {
                /* DEBUG
                echo '<br />sourceW > sourceHeight<br />';
                echo 'maxWidth: '.$this->maxWidth.'<br />';
                /**/
                $this->thumbWidth = $this->maxWidth;
                $this->thumbHeight = floor($this->sourceHeight * ($this->maxWidth/$this->sourceWidth));
                // DEBUG echo 'thumbW = : '.$this->thumbWidth.'<br />';
            }
            else if($this->sourceWidth < $this->sourceHeight)
            {
                /** DEBUG
                echo '<br />sourceW < sourceHeight<br />';
                echo 'maxHeight: '.$this->maxHeight.'<br />';
                /**/
                $this->thumbHeight = $this->maxHeight;
                $this->thumbWidth = floor($this->sourceWidth * ($this->maxHeight/$this->sourceHeight));
                // DEBUG echo 'thumbH = : '.$this->thumbHeight.'<br />';
            }
            else
            {
                $this->thumbWidth = $this->maxWidth;
                $this->thumbHeight = $this->maxHeight;
            }   
        }
        else
        {
            $this->thumbWidth = $this->mawWidth;
            $this->thumbHeight = $this->maxHeight;
        }
        /* DEBUG
        echo 'thumbW : '.$this->thumbWidth.'<br />';
        echo 'thumbH : '.$this->thumbHeight.'<br />';
        /**/
        $this->thumb = imagecreatetruecolor($this->thumbWidth,$this->thumbHeight);
        if($this->sourceWidth <= $this->mawWidth &&
            $this->sourceHeight <= $this->maxHeight &&
            $this->inflate == false
           )
        {
            $this->thumb = $this->source;
        }
        else
        {
            imagecopyresampled($this->thumb,$this->source,0,0,0,0,
                $this->thumbWidth,$this->thumbHeight,
                $this->sourceWidth,$this->sourceHeight);
        }
    }
}
?>