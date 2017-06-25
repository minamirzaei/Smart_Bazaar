<?php

namespace AppBundle\Controller;

use AppBundle\Controller\AppController;
use AppBundle\Entity\Product\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/cart", name="cart_add")
 */
class CartController extends AppController {

    /**
     * @Route("/cart_add/{id}", name="cart_add")
     * @ParamConverter("product" ,class="AppBundle:Product\Product")
     */
    public function addShoppingCartAction(Request $request, Product $product) {

        $cart = $request->getSession()->get("cart", []);

        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()] ++;
        } else {
            $cart[$product->getId()] = 1;
        }

        $request->getSession()->set("cart", $cart);
        var_dump($cart);


        return $this->redirectToRoute("home_index");
    }

    /**
     * @Route("/cart_addcount/{id}", name="cart_add_count")
     * @ParamConverter("product" ,class="AppBundle:Product\Product")
     * @Template
     */
    public function addCountAction(Request $request, Product $product) {

        $cart = $request->getSession()->get("cart", []);
//        var_dump($cart);
        $id = $product->getId();
        //   echo $id;


        foreach ($cart as $key => $c) {

            if ($key == $id) {
                $c+=1;
//                echo "<br>" . "count:";
//                echo $c;

                $cart = $request->getSession()->get("cart", []);

                if (isset($cart[$product->getId()])) {
                    $cart[$product->getId()] = $c;
                    $request->getSession()->set("cart", $cart);
//                    var_dump($cart);
                }
            }
        }

        return $this->redirectToRoute("cart_checkout");
    }

    /**
     * @Route("/cart_reducecount/{id}", name="cart_reduce_count")
     * @ParamConverter("product" ,class="AppBundle:Product\Product")
     * @Template
     */
    public function reduceCountAction(Request $request, Product $product) {

        $cart = $request->getSession()->get("cart", []);
//        var_dump($cart);
        $id = $product->getId();
        echo $id;


        foreach ($cart as $key => $c) {

            if ($key == $id) {
                $c-=1;
//                echo "<br>" . "count:";
//                echo $c;
                $cart = $request->getSession()->get("cart", []);
                if (isset($cart[$product->getId()])) {
                    
                }
                $cart[$product->getId()] = $c;
                $request->getSession()->set("cart", $cart);
//                var_dump($cart);
            }
        }

        return $this->redirectToRoute("cart_checkout");
    }

    /**
     * @Route("/checkout", name="cart_checkout")
     * @ Template
     */
    public function checkoutAction(Request $request) {

        $cart = $request->getSession()->get("cart", []);
        // var_dump($cart);

        $products = $this->getEm()->getRepository('AppBundle:Product\Product')->findAll();

        foreach ($products as $p) {
            foreach ($cart as $key => $c) {
                if ($p->getId() == $key) {
                    $Count = $c;
                    $order[] = array
                        ("id" => $p->getId(), "name" => $p->getName(),
                        "price" => $p->getPrice(), "quantity" => $p->getQuantity(),
                        "count" => $Count);
                }
            }
        }
        //  var_dump($order);
//        var_dump($cart);
//        $cartCookie = $response->headers->setCookie(new Cookie('cart', $cart));

        $response = $this->render('AppBundle:Cart:checkout.html.twig', array(
            "order" => $order,
            "cart" => $cart,
        ));


        //json_encode($order)
        $OrderSerialize = serialize($order);
        $OrderUnSerialize = unserialize($OrderSerialize);
        $response->headers->setCookie(new Cookie('cart', $OrderSerialize));
        $dbSerialize = $response->headers->getCookies();
     //   var_dump($dbSerialize);
//        $db = unserialize($dbSerialize);
//        var_dump($db);
//        echo "order:";
//        var_dump($order);
//        echo "serlai";
//        var_dump($OrderSerialize);
//        echo "un serail:";
//        var_dump($OrderUnSerialize);


        return $response;
    }

    /**
     *
     * @Route("/ordertodb", name="cart_order_db")
     * @ Template
     */
    public function orderToDbAction(Request $request) {

        $response = $this->render('AppBundle:Cart:orderToDb.html.twig', array(
        ));

        $dbSerialize = $response->headers->getCookies();
        var_dump($dbSerialize);


        return $response;
    }

}
