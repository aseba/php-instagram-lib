<?php

namespace aseba\Instagram;

class InstagramRepository
{
    private $instagram;

    public function __construct(Instagram $instagram)
    {
        $this->instagram = $instagram;
        $this->pagination = null;
    }

    public function getPaginationInfo()
    {
        return $this->pagination;
    }

    public function getInstagramsFromHashtag($hashtag, $max_tag_id = null, $min_tag_id = null)
    {
        if (is_null($max_tag_id)) {
            $content = $this->instagram->generic(sprintf('/tags/%s/media/recent', $hashtag));
        } else {
            $content = $this->instagram->generic(
          sprintf('/tags/%s/media/recent', $hashtag),
          ['max_tag_id' => $max_tag_id]
        );
        }
        $this->pagination = $content->pagination;

        return $content->data;
    }
}
