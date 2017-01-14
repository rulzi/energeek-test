<?php
namespace App\Controller;

use App\Controller;
use App\Model\Transaction;
use App\Model\Customer;

// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;

class TransactionController extends Controller
{
    public function indexAction($request, $response, $param)
    {
        $transactions = Transaction::where('customer_id', $param['customer_id'])->get();

        $data = [
            'transactions' => $transactions,
            'customer_id' => $param['customer_id'],
        ];

        return $this->view->render($response, 'transaction/index.twig', $data);
    }

    public function addAction($request, $response, $param)
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
            'customer_id' => $param['customer_id'],
        ];

        return $this->view->render($response, 'transaction/add.twig', $data);
    }

    public function saveAction($request, $response, $param)
    {
        $this->validator->rule('required', [
            'tanggal_transaksi',
            'type',
            'nominal',
        ]);

        if($this->validate()) {
            $input = $request->getParsedBody();


            foreach ($input['nominal'] as $value) {
                $transaction = new Transaction;

                $transaction->param = $param['customer_id'];
                $transaction->nominal = $value;
                $transaction->tanggal_transaksi = $input['tanggal_transaksi'];
                $transaction->type = $input['type'];

                $transaction = $transaction->save();
            }

            
            $this->flash->addMessage('success', 'Add Success');
            
        }

        return $response->withRedirect($this->router->pathFor('transactionAdd', $param['customer_id']));
    }

    public function editAction($request, $response, $param)
    {

        $transaction = Transaction::find($param['id']);

        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);

        $data = [
            'transaction' => $transaction,
            'nameKey' => $nameKey,
            'valueKey' => $valueKey,
            'name' => $name,
            'value' => $value,
            'customer_id' => $param['customer_id'],
        ];

        return $this->view->render($response, 'transaction/edit.twig', $data);
    }

    public function updateAction($request, $response, $param)
    {
        $this->validator->rule('required', [
            'tanggal_transaksi',
            'type',
            'nominal',
        ]);

        $input = $request->getParsedBody();
        if($this->validate()) {

            $transaction = Transaction::find($input['id']);

            $transaction->customer_id = $param['customer_id'];
            $transaction->nominal = $input['nominal'];
            $transaction->tanggal_transaksi = $input['tanggal_transaksi'];
            $transaction->type = $input['type'];

            $transaction = $transaction->save();

            if($transaction) {
                $this->flash->addMessage('success', 'Update Success');
            }
        }

        return $response->withRedirect($this->router->pathFor('transactionEdit', ['id' => $input['id'], 'customer_id' => $param['customer_id']] ));
    }

    public function deleteAction($request, $response)
    {
        $input = $request->getParsedBody();

        $transaction = Transaction::find($input['id']);

        $delete = $transaction->delete();

        if($delete) {
            $this->flash->addMessage('success', 'Deleted Success');
        }

        return $response->withRedirect($this->router->pathFor('transactions', $param['customer_id']));
    }
}
