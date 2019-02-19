
<?php
class App
{
    private $proxy;
    public function __construct(Container $container)
    {
        echo "App::__construct\n";
        $this->proxy = $container->getProxy();
    }
    public function hello()
    {
        echo "App::hello\n";
        return $this->proxy->hello();
    }
}
class Proxy
{
    private $curl;
    public function __construct(Container $container)
    {
        echo "Proxy::__construct\n";
        $this->curl = $container->getCurl();
    }
    public function hello()
    {
        return $this->curl->doGet();
    }
}
class Curl
{
    public function doGet()
    {
        echo "Curl::doGet\n";
        return "Hello";
    }
}
class Container
{
    public function getProxy()
    {
        return new Proxy($this);
    }
    public function getCurl()
    {
        return new Curl();
    }
}
$app = new App(new Container());
echo $app->hello();