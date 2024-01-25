<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Message::class)]
    private Collection $sender;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: Message::class)]
    private Collection $receiver;

    #[ORM\OneToMany(mappedBy: 'user1', targetEntity: Connection::class)]
    private Collection $user1;

    #[ORM\OneToMany(mappedBy: 'user2', targetEntity: Connection::class)]
    private Collection $user2;

    public function __construct()
    {
        $this->sender = new ArrayCollection();
        $this->receiver = new ArrayCollection();
        $this->user1 = new ArrayCollection();
        $this->user2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(Message $sender): static
    {
        if (!$this->sender->contains($sender)) {
            $this->sender->add($sender);
            $sender->setSender($this);
        }

        return $this;
    }

    public function removeSender(Message $sender): static
    {
        if ($this->sender->removeElement($sender)) {
            // set the owning side to null (unless already changed)
            if ($sender->getSender() === $this) {
                $sender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(Message $receiver): static
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver->add($receiver);
            $receiver->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiver(Message $receiver): static
    {
        if ($this->receiver->removeElement($receiver)) {
            // set the owning side to null (unless already changed)
            if ($receiver->getReceiver() === $this) {
                $receiver->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Connection>
     */
    public function getUser1(): Collection
    {
        return $this->user1;
    }

    public function addUser1(Connection $user1): static
    {
        if (!$this->user1->contains($user1)) {
            $this->user1->add($user1);
            $user1->setUser1($this);
        }

        return $this;
    }

    public function removeUser1(Connection $user1): static
    {
        if ($this->user1->removeElement($user1)) {
            // set the owning side to null (unless already changed)
            if ($user1->getUser1() === $this) {
                $user1->setUser1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Connection>
     */
    public function getUser2(): Collection
    {
        return $this->user2;
    }

    public function addUser2(Connection $user2): static
    {
        if (!$this->user2->contains($user2)) {
            $this->user2->add($user2);
            $user2->setUser2($this);
        }

        return $this;
    }

    public function removeUser2(Connection $user2): static
    {
        if ($this->user2->removeElement($user2)) {
            // set the owning side to null (unless already changed)
            if ($user2->getUser2() === $this) {
                $user2->setUser2(null);
            }
        }

        return $this;
    }

    
}
