<?php
declare(strict_types=1);


namespace App;


class Response
{
    private int $status;
    private string $mime;

    private string $layout = 'default';
    private string $view;
    private array $data = [];

    public function __construct(int $status = 200, string $mime = "text/html")
    {
        $this->status = $status;
        $this->mime = $mime;
    }

    public function writeHeaders() {
        header($_SERVER["SERVER_PROTOCOL"] . ' ' . $this->status);
        header('Content-Type: {$this->mime}; charset=UTF-8');
    }
    /**
     * @param string $view
     * @param string $layout
     * @param array $data
     * @return string
     */
    public function render(): string {

        extract($this->data);

        // Change: Integrate the FlashMessage management
        //$flashMessage = App::get("flash");
        //$router = App::get(Router::class);
        //$user = App::get('user');
        //$config = App::get("config");

        ob_start();
        require __DIR__ . "/../views/{$this->view}.view.php";
        $content = ob_get_clean();

        ob_start();
        require __DIR__ . "/../views/layouts/{$this->layout}.layout.php";

        return ob_get_clean();
    }


    public function setView(string $view)
    {
        $this->view = $view;
    }

    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    public function setData(array $compact)
    {
        $this->data = $compact;
    }
}