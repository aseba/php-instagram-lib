<?php

namespace aseba\Instagram;

class IterableHashtag implements \Iterator
{
    public function __construct(InstagramRepository $repository, $hashtag)
    {
        $this->repository = $repository;
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
        $content = $this->repository->getInstagramsFromHashtag($this->hashtag, $this->max_tag_id);
        $this->pagination = $this->repository->getPaginationInfo();
        $this->content = $content;

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
