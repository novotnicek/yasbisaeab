<?php

namespace App\Entity;

use App\Repository\BlogPostCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogPostCommentRepository::class)]
class BlogPostComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    // #[ORM\ManyToOne(inversedBy: 'blogPostComments')]
    // #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    // private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'blogPostComments')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?BlogPost $blogPost = null;

    // TODO: we want discuss in threads...

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'blogPostComments')]
    private ?self $parent = null; // parent blogPostComment

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $blogPostComments;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // TODO: and we want redact f#!$ morons in discussion...

    #[ORM\Column]
    private bool $isPublished = false;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $redactedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $redactedBy = null;

    public function __construct()
    {
        $this->blogPostComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    // public function getUser(): ?User
    // {
    //     return $this->user;
    // }

    // public function setUser(?User $user): static
    // {
    //     $this->user = $user;

    //     return $this;
    // }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getBlogPost(): ?BlogPost
    {
        return $this->blogPost;
    }

    public function setBlogPost(?BlogPost $blogPost): static
    {
        $this->blogPost = $blogPost;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getBlogPostComments(): Collection
    {
        return $this->blogPostComments;
    }

    public function addBlogPostComment(self $blogPostComment): static
    {
        if (!$this->blogPostComments->contains($blogPostComment)) {
            $this->blogPostComments->add($blogPostComment);
            $blogPostComment->setParent($this);
        }

        return $this;
    }

    public function removeBlogPostComment(self $blogPostComment): static
    {
        if ($this->blogPostComments->removeElement($blogPostComment)) {
            // set the owning side to null (unless already changed)
            if ($blogPostComment->getParent() === $this) {
                $blogPostComment->setParent(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getRedactedAt(): ?\DateTimeImmutable
    {
        return $this->redactedAt;
    }

    public function setRedactedAt(?\DateTimeImmutable $redactedAt): static
    {
        $this->redactedAt = $redactedAt;

        return $this;
    }

    public function getRedactedBy(): ?User
    {
        return $this->redactedBy;
    }

    public function setRedactedBy(?User $redactedBy): static
    {
        $this->redactedBy = $redactedBy;

        return $this;
    }
}
