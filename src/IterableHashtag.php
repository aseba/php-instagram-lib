<?php

namespace aseba\Instagram;

class IterableHashtag implements \Iterator
{
    private $repository;
    private $hashtag;
    private $pagination;
    private $content;
    private $position;

    public function __construct(InstagramRepository $repository, $hashtag)
    {
      $this->repository = $repository;
      $this->hashtag = $hashtag;

      $this->pagination = [];
      $this->content = [];

      $this->position = 0;
    }

    public function rewind()
    {
      $this->position = 0;
    }

    public function valid()
    {
      return
        !is_null($this->pagination[$this->position-1]->next_max_tag_id)
        or $this->position == 0;
    }

    public function next()
    {
      ++$this->position;
    }

    public function current()
    {
      if(!isset($this->content[$this->position])) {
        $content = $this->repository->getInstagramsFromHashtag(
          $this->hashtag,
          $this->pagination[$this->position-1]->next_max_tag_id
        );
        $this->pagination[$this->position] = $this->repository->getPaginationInfo();
        $this->content[$this->position] = $content;
      }

      return $this->content[$this->position];
    }

    public function key()
    {
      return $this->position;
    }
}
