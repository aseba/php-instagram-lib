<?php

namespace aseba\Instagram;

class IterableHashtag implements \Iterator
{
    public function __construct(Instagram $instagram, $hashtag)
    {
        $this->instagram = $instagram;
        $this->hashtag = $hashtag;

        $this->pagination = null;
        $this->content = null;

        $this->max_tag_id = null;
    }

    public function rewind()
    {
    }

    public function valid()
    {
        if (is_null($this->pagination)) {
            return true;
        } else {
            return !(is_null($this->max_tag_id));
        }
    }

    public function next()
    {
        if (!is_null($this->pagination) && isset($this->pagination->next_max_tag_id)) {
            $this->max_tag_id = $this->pagination->next_max_tag_id;
        } else {
            $this->max_tag_id = null;
        }
    }

    public function current()
    {
        if (is_null($this->max_tag_id)) {
            $content = $this->instagram->generic(sprintf('/tags/%s/media/recent', $this->hashtag));
        } else {
            $content = $this->instagram->generic(
        sprintf('/tags/%s/media/recent', $this->hashtag),
        ['max_tag_id' => $this->max_tag_id]
      );
        }

        $this->pagination = $content->pagination;
        $this->content = $content->data;

        return $this->content;
    }

    public function key()
    {
        return [
      'max_tag_id' => $this->max_tag_id,
      'min_tag_id' => $this->min_tag_id,
    ];
    }
}
