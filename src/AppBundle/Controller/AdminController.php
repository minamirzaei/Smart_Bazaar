<?php

namespace AppBundle\Controller;

use AppBundle\Controller\AppController;
use AppBundle\Upload\Handler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Amin controller.
 *
 * @Route("/admin")
 */
class AdminController extends AppController {

    /**
     * @Route("/home", name="admin_home")
     * @Template
     */
    public function homeAction() {



        return array();
    }

    /**
     * @Route("/products", name="admin_products")
     * @Template
     */
    public function indexProductsAction() {



        return array();
    }

    /**
     * @Route("/price", name="admin_price")
     * @Template
     */
    public function priceAction() {



        return array();
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //***************************************Upload Images of Products*****************************************************
    /**
     *
     * @Route("/upload/{key}", name="upload")
     * @Template
     */
    public function uploadAction(Request $request, $key = null) {
        if ($key === null) {
            $key = uniqid();
            return $this->redirectToRoute("upload", ["key" => $key]);
        }
        $form = $this->createFormBuilder()
                ->add("name")
                ->add("save", SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            var_dump($request->getSession()->get("files_$key"));
            // should move image files to another files
        }
        return['form' => $form->createView(), "key" => $key];
    }

    /**
     *
     * @Route("/uploader/{key}", name="uploader")
     * @Method({"POST", "DELETE"})
     */
    public function uploaderAction(Request $request, $key) {

//require_once "handler.php";
//        var_dump($_FILES);
//        die();
        $uploader = new Handler();

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array('jpeg', 'jpg', 'gif', 'png', 'pdf', 'mp4', 'zip', 'mp3'); // all files types allowed by default
// Specify max file size in bytes.
        $uploader->sizeLimit = null;

// Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default
// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method = $this->get_request_method();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.

        if ($method == "POST") {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done
            if (isset($_GET["done"])) {
                $result = $uploader->combineChunks("files");
            }
            // Handles upload requests
            else {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                $result = $uploader->handleUpload("files");

                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }



            $session = $request->getSession();
            $files = $session->get("files_$key", []);
            $files[] = $result;
            $session->set("files_$key", $files);




//            echo json_encode($result);
            return new JsonResponse($result);
        }
// for delete file requests
        else if ($method == "DELETE") {
            $result = $uploader->handleDelete("files");
            return new JsonResponse($result);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
        }


//        return new JsonResponse();
    }

    private function get_request_method() {
        global $HTTP_RAW_POST_DATA;

        if (isset($HTTP_RAW_POST_DATA)) {
            parse_str($HTTP_RAW_POST_DATA, $_POST);
        }

        if (isset($_POST["_method"]) && $_POST["_method"] != null) {
            return $_POST["_method"];
        }

        return $_SERVER["REQUEST_METHOD"];
    }

}
