<?php
namespace app\components;

use yii\base\Component;

use Yii;

class OrderHelp extends Component {

    CONST HOST_NAME = 'https://opencart.fokin-team.ru/';

    public function do_curl_request($url, $params=array()) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, self::HOST_NAME . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/apicookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/apicookie.txt');
    
        $params_string = '';
        if (is_array($params) && count($params)) {
            foreach($params as $key=>$value) {
                $params_string .= $key.'='.$value.'&'; 
            }
            rtrim($params_string, '&');
    
            curl_setopt($ch,CURLOPT_POST, count($params));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $params_string);
        }
    
        //execute post
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function CCreate($data, $api_token)
    {
        $url = 'index.php?route=api/customer&api_token=' . $api_token;

        $fields = array(
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
        );
        
        $json = json_decode($this->do_curl_request($url, $fields));

        return $json;
    }

    
    public function COrder($api_token)
    {
        $url = 'index.php?route=api/order/add&api_token=' . $api_token;

        $json = json_decode($this->do_curl_request($url));

        return $json;
    }

    public function COrderInfo($order_id)
    {
        $url = 'index.php?route=api/order/info&order_id=' . $order_id;

        $json = json_decode($this->do_curl_request($url));

        return $json;
    }

    public function CPayment($data, $api_token)
    {
        $url = 'index.php?route=api/payment/address&api_token=' . $api_token;

        $fields = array(
            'firstname'=>$data['firstname'],
            'lastname'=>$data['lastname'],
            'address_1'=>$data['address_1'],
            'city'=>$data['city'],
            'country_id'=>'RUS',
            'zone_id'=>'KGD'
        );
        
        $json = json_decode($this->do_curl_request($url, $fields));

        return $json;
    }

    public function CPaymentMethod($payment_method, $api_token)
    {
        $url = 'index.php?route=api/payment/method&api_token=' . $api_token;

        $fields = array(
            'payment_method'=>$payment_method
        );
        
        $json = json_decode($this->do_curl_request($url, $fields));

        return $json;
    }

    public function CPaymentMethods($api_token)
    {
        $url = 'index.php?route=api/payment/methods&api_token=' . $api_token;
        
        $json = json_decode($this->do_curl_request($url));

        return $json;
    }

    public function CShippingMethod($shipping_method, $api_token)
    {
        $url = 'index.php?route=api/shipping/method&api_token=' . $api_token;

        $fields = array(
            'shipping_method'=>$shipping_method
        );
        
        $json = json_decode($this->do_curl_request($url, $fields));

        return $json;
    }

    public function CShippingMethods($api_token)
    {
        $url = 'index.php?route=api/shipping/methods&api_token=' . $api_token;
        
        $json = json_decode($this->do_curl_request($url));

        return $json;
    }

    public function CShipping($data, $api_token)
    {
        $url = 'index.php?route=api/shipping/address&api_token=' . $api_token;

        $fields = array(
            'firstname'=>$data['firstname'],
            'lastname'=>$data['lastname'],
            'address_1'=>$data['address_1'],
            'city'=>$data['city'],
            'country_id'=>'RUS',
            'zone_id'=>'KGD'
        );
        
        $json = json_decode($this->do_curl_request($url, $fields));

        return $json;
    }

    // array products
    // string firstname
    // string lastname
    // string address_1
    // string city'
    // string email
    // string telephone

    // string country_id=>'RUS',
    // string zone_id=>'KGD'
    public function Checkout($data)
    {
        $output = [];

        $output['token'] = $this->CLogin();
        $output['customer'] = $this->CCreate($data, $output['token']);

        $output['cart'] = $this->CCart($data['products'], $output['token']);

        $output['payment'] = $this->CPayment($data, $output['token']);
        $output['payment-methods'] = $this->CPaymentMethods($output['token']);

        foreach ($output['payment-methods']->payment_methods as $payment_method) {
            $output['payment-method'] = $this->CPaymentMethod($payment_method->code, $output['token']);
            break;
        }

        $output['shipping'] = $this->CShipping($data, $output['token']);
        $output['shipping-methods'] = $this->CShippingMethods($output['token']);

        foreach ($output['shipping-methods']->shipping_methods as $shipping_method) {
            foreach ($shipping_method->quote as $quote) {
                $output['shipping-method'] = $this->CShippingMethod($quote->code, $output['token']);
                break 2;
            }
        }

        $output['order'] = $this->COrder($output['token']);

        return $output['order']->order_id;
    }

    public function CLogin()
    {
        $apiKey = 'AT7L91vsRTYehVyFLGv8UATINfjgrtNJh7nJ2cOuqmRlcBWgyxEFEIYEBnEhtHby7ciDtDIgo24PJZNSjAAob5lj3j0k6QrJBrylNMwjCNZ7ngFPk0DjPH9EVPQPnZntSg65GpFGrdEasDOGe0ncfI1EhJyqAU1thb4YOx7pP9lr9Yd86uyjB8O92v8zMiVaUSQkggt66BNG0RO18jKYynJiYXeivnJ5vToPsZRA4EyPFbVuCC5Owl15hrCHRCEq';

        $url = 'index.php?route=api/login';
 
        $fields = array(
            'username' => 'Default',
            'key' => $apiKey,
        );
        
        $json = json_decode($this->do_curl_request($url, $fields));
        $api_token = $json->api_token;
        
        return $api_token;
    }

    public function CCart($productIds, $token)
    {
        $output = [];
        $url = 'index.php?route=api/cart/add&api_token='. $token;

        foreach ((array)$productIds as $product_id) {
            $fields = array(
                'product_id' => intval($product_id),
                // 'quantity' => 1
            );
            
            $json = $this->do_curl_request($url, $fields);
            $output['products'][] = $json;
        }

        return $output;
    }

    public function SetCheckout($productIds)
    {

        // $apiKey = 'AT7L91vsRTYehVyFLGv8UATINfjgrtNJh7nJ2cOuqmRlcBWgyxEFEIYEBnEhtHby7ciDtDIgo24PJZNSjAAob5lj3j0k6QrJBrylNMwjCNZ7ngFPk0DjPH9EVPQPnZntSg65GpFGrdEasDOGe0ncfI1EhJyqAU1thb4YOx7pP9lr9Yd86uyjB8O92v8zMiVaUSQkggt66BNG0RO18jKYynJiYXeivnJ5vToPsZRA4EyPFbVuCC5Owl15hrCHRCEq';

        // $url = $this->hostname . 'index.php?route=api/login';
 
        // $fields = array(
        //     'username' => 'Default',
        //     'key' => $apiKey,
        // );
        
        // $json = json_decode($this->do_curl_request($url, $fields));
        $api_token = $this->CLogin();//$json->api_token;

        $output = $this->CCreate(null, $api_token);

        $this->CCart($productIds, $api_token);

        return $api_token;
    }
}