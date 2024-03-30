<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan as ModelPelanggan;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;


class Pelanggan extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Pelanggan'
        ];
        return view('pelanggan/datapelanggan', $title);
    }

    public function view()
    {
        $db = db_connect();
        $pelanggan = $db->table('pelanggan')->select('kdplg, namaplg, alamat, nohp');
        return DataTable::of($pelanggan)
            // ->edit('level', function ($row) {
            //     return ($row->level == 1) ? 'Admin' : 'Pelanggan';
            // })
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-kdplg="' . $row->kdplg . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-kdplg="' . $row->kdplg . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-kdplg="' . $row->kdplg . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        return view('pelanggan/formtambah');
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $kdplg = $this->request->getPost('kdplg');
            $namaplg = $this->request->getPost('namaplg');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');

            $rules = [
                'kdplg' => [
                    'label' => 'Kode Pelanggan',
                    'rules' => 'required|is_unique[pelanggan.kdplg]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada, coba kode yang lain'

                    ]
                ],
                'namaplg' => [
                    'label' => 'Nama Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'

                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'

                    ]
                ],
                'nohp' => [
                    'label' => 'No Hp',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus angka'

                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                $json = [
                    'error' => $errors
                ];
            } else {
                $modelpelanggan = new ModelPelanggan();
                $modelpelanggan->insert([
                    'kdplg' => $kdplg,
                    'namaplg' => $namaplg,
                    'alamat' => $alamat,
                    'nohp' => $nohp,
                ]);

                $json = [
                    'sukses' => 'Data Pelanggan Berhasil Di Simpan'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $kdplg = $this->request->getPost('kdplg');

            $modelpelanggan = new ModelPelanggan();
            $modelpelanggan->where('kdplg', $kdplg)->delete();

            $json = [
                'sukses' => 'Data Pelanggan Berhasil Dihapus'
            ];

            return $this->response->setJSON($json);
        }
    }

    public function formedit($kdplg)
    {
        $modelpelanggan = new ModelPelanggan();
        $pelanggan = $modelpelanggan->where('kdplg', $kdplg)->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan');
        }

        $data = [
            'pelanggan' => $pelanggan
        ];

        return view('pelanggan/formedit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kdplg = $this->request->getPost('kdplg');
            $namaplg = $this->request->getPost('namaplg');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');

            $rules = $this->validate([

                'namaplg' => [
                    'label' => 'Nama tamu',
                    'rules' => 'required|',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'

                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required|',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'

                    ]
                ],
                'nohp' => [
                    'label' => 'No Hp',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus angka'

                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();
                $error = [
                    'error_namaplg' => $validation->getError('namaplg'),
                    'error_alamat' => $validation->getError('alamat'),
                    'error_nohp' => $validation->getError('nohp'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_tamu = new ModelPelanggan();
                $model_tamu->update($kdplg, [
                    'namaplg' => $namaplg,
                    'alamat' => $alamat,
                    'nohp' => $nohp,
                ]);

                $json = [
                    'sukses' => 'Data tamu Dengan Nama ' . $namaplg . ' Berhasil Di Update'
                ];
            }
            echo json_encode($json);
        }
    }

    public function detail($kdplg)
    {
        $modelpelanggan = new ModelPelanggan();
        $pelanggan = $modelpelanggan->where('kdplg', $kdplg)->first();

        if (!$pelanggan) {
            return 'Data pelanggan tidak ditemukan';
        }

        return view('pelanggan/detail', ['pelanggan' => $pelanggan]);
    }
}
