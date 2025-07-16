<?php

class Conversations {

    private $path;

    public function __construct(string $path)
    {
        if (!$path) {
            throw new \Exception('Null conversations path');
        }
        if (strpos($path, 'conversations') === false) {
            throw new \Exception("Invalid conversations path: $path");
        }
        $this->path = $path;
    }

    public function getConversation(int $id): array
    {
        $path = $this->path."/$id";
        if (!file_exists($path)) {
            throw new \Exception("Conversation $id could not be found.");
        }
        $file = file_get_contents($path);
        return json_decode($file, true);
    }

    public function saveConversation(int $id, array $conversation)
    {
        file_put_contents($this->path."/$id", json_encode($conversation, JSON_PRETTY_PRINT));
    }

    public function getCurrentConversationId()
    {
        $path = $this->path."/.current";
        if (!file_exists($path)) {
            return $this->newConversationId();
        }
        $id = file_get_contents($path);
        if (!$id) {
            return $this->newConversationId();
        }
        return $id;
    }

    public function setCurrentConversationId(int $id)
    {
        file_put_contents($this->path."/.current", $id);
    }

    public function newConversationId() {
        $id = (microtime(true)*10000);
        if (file_exists($this->path."/$id")) {
            throw new \Exception("Tried to create new conversation but it already exists!");
        }
        $this->saveConversation($id, []);
        $this->setCurrentConversationId($id);
        return $id;
    }

    private function getConversationIds()
    {
        $dir = $this->path;
        $glob = glob($dir . '/*');

        $conversations = [];

        foreach ($glob as $file) {
            if (is_file($file) && (strpos($file, "current") === false)) {
                $conversations[] = basename($file);
            }
        }
        return $conversations;
    }

    public function getConversations()
    {
        $ids = $this->getConversationIds();
        $conversations = [];
        $i = 1;
        foreach ($ids as $id) {
            if (is_file($this->path."/$id")) {
                $raw = file_get_contents($this->path."/$id");
                $body = json_decode($raw, true);
                $conversations[] = [
                    'index' => $i,
                    'id' => $id,
                    'preview' => ($body[0]['content'] ?? 'null')
                ];
                $i++;
            }
        }
        return $conversations;
    }

    public function trash(int $id)
    {
        if (!file_exists($this->path."/$id")) {
            throw new \Exception("Conversation $id does not exist.");
        }
        return unlink($this->path."/$id");
    }
    
}