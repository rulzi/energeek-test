<?php
namespace App\Controller;

use App\Controller;
use App\Model\Customer;

// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;

class CustomerController extends Controller
{
    public function indexAction($request, $response)
    {
        $customers = Customer::all();

        $data = [
            'customers' => $customers
        ];

        return $this->view->render($response, 'customer/index.twig', $data);
    }

    public function addAction($request, $response)
    {
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);

        $data = [
            'nameKey' => $nameKey,
            'valueKey' => $valueKey,
            'name' => $name,
            'value' => $value,
        ];

        return $this->view->render($response, 'customer/add.twig', $data);
    }

    public function saveAction($request, $response)
    {
        $this->validator->rule('required', [
            'nik',
            'nama',
            'alamat',
            'email',
            'telp',
            'tempat_lahir',
            'tanggal_lahir',
        ]);

        if($this->validate()) {
            $input = $request->getParsedBody();

            $customer = new Customer;

            $uploadFileName = '';
            $files = $request->getUploadedFiles();
            if (!empty($files['image'])) {
                $image = $files['image'];

                if ($image->getError() === UPLOAD_ERR_OK) {
                    $uploadFileName = $image->getClientFilename();
                    $image->moveTo("upload/$uploadFileName");
                }
            }


            $customer->nik = $input['nik'];
            $customer->nama = $input['nama'];
            $customer->alamat = $input['alamat'];
            $customer->email = $input['email'];
            $customer->telp = $input['telp'];
            $customer->tempat_lahir = $input['tempat_lahir'];
            $customer->tanggal_lahir = $input['tanggal_lahir'];
            $customer->foto = $uploadFileName;

            $customer = $customer->save();

            if($customer) {
                $this->flash->addMessage('success', 'Add Success');
            }
        }

        return $response->withRedirect($this->router->pathFor('customerAdd'));
    }

    public function editAction($request, $response, $id)
    {

        $customer = Customer::find($id);

        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);

        $data = [
            'customer' => $customer,
            'nameKey' => $nameKey,
            'valueKey' => $valueKey,
            'name' => $name,
            'value' => $value,
        ];

        return $this->view->render($response, 'customer/edit.twig', $data);
    }

    public function updateAction($request, $response)
    {
        $this->validator->rule('required', [
            'nik',
            'nama',
            'alamat',
            'email',
            'telp',
            'tempat_lahir',
            'tanggal_lahir',
        ]);

        $input = $request->getParsedBody();
        if($this->validate()) {

            $customer = Customer::find($input['id']);

            $files = $request->getUploadedFiles();
            if (!empty($files['image'])) {
                $image = $files['image'];

                if ($image->getError() === UPLOAD_ERR_OK) {
                    $uploadFileName = $image->getClientFilename();
                    $image->moveTo("upload/$uploadFileName");
                    $customer->foto = $uploadFileName;
                }
            }


            $customer->nik = $input['nik'];
            $customer->nama = $input['nama'];
            $customer->alamat = $input['alamat'];
            $customer->email = $input['email'];
            $customer->telp = $input['telp'];
            $customer->tempat_lahir = $input['tempat_lahir'];
            $customer->tanggal_lahir = $input['tanggal_lahir'];

            $customer = $customer->save();

            if($customer) {
                $this->flash->addMessage('success', 'Update Success');
            }
        }

        return $response->withRedirect($this->router->pathFor('customerEdit', ['id' => $input['id']] ));
    }

    public function deleteAction($request, $response)
    {
        $input = $request->getParsedBody();

        $customer = Customer::find($input['id']);

        $delete = $customer->delete();

        if($delete) {
            $this->flash->addMessage('success', 'Deleted Success');
        }

        return $response->withRedirect($this->router->pathFor('customers'));
    }
}
