<?php
class DatabaseException extends Exception {
    private string $method;
    private string $sql;

    public function __construct(string $mensaje, string $method, string $sql="") {
        parent::__construct($mensaje);
        $this->method= $method;
        $this->sql= $sql;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function setMethod($method): void {
        $this->method= $method;
    }

    public function getSql(): string {
        return $this->sql;
    }

    public function setSql($sql): void {
        $this->sql= $sql;
    }
}