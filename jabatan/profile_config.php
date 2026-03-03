<?php
$profileSections = [
    [
        'title' => 'Data Pribadi',
        'rows' => [
            ['label' => 'Nama lengkap', 'editKey' => 'nama', 'source' => 'profile', 'field' => 'nama'],
            ['label' => 'Tempat & tanggal lahir', 'editKey' => 'ttl', 'source' => 'ttl'],
            ['label' => 'Jenis kelamin', 'editKey' => 'jenis_kelamin', 'source' => 'profile', 'field' => 'jenis_kelamin'],
            ['label' => 'Status pernikahan', 'editKey' => 'status_pernikahan', 'source' => 'profile', 'field' => 'status_pernikahan'],
            ['label' => 'Kewarganegaraan', 'editKey' => 'kewarganegaraan', 'source' => 'profile', 'field' => 'kewarganegaraan']
        ]
    ],
    [
        'title' => 'Foto Profil',
        'rows' => [
            ['label' => 'Pas foto karyawan terbaru', 'editKey' => 'foto', 'type' => 'photo']
        ]
    ],
    [
        'title' => 'Informasi Kontak',
        'rows' => [
            ['label' => 'Nomor HP', 'editKey' => 'nomor_hp', 'source' => 'profile', 'field' => 'nomor_hp'],
            ['label' => 'Email', 'editKey' => 'email', 'source' => 'profile', 'field' => 'email'],
            ['label' => 'Alamat domisili', 'editKey' => 'alamat_domisili', 'source' => 'profile', 'field' => 'alamat_domisili']
        ]
    ],
    [
        'title' => 'Nomor Identitas',
        'rows' => [
            ['label' => 'NIK (KTP)', 'editKey' => 'nik', 'source' => 'profile', 'field' => 'nik'],
            ['label' => 'NPWP', 'editKey' => 'npwp', 'source' => 'profile', 'field' => 'npwp'],
            ['label' => 'Nomor BPJS Kesehatan & Ketenagakerjaan', 'editKey' => 'bpjs', 'source' => 'bpjs']
        ]
    ],
    [
        'title' => 'Data Pekerjaan',
        'rows' => [
            ['label' => 'NIP / Employee ID', 'editKey' => 'nip', 'source' => 'profile', 'field' => 'nip'],
            ['label' => 'Jabatan', 'editKey' => 'jabatan', 'source' => 'jabatan'],
            ['label' => 'Departemen / Divisi', 'editKey' => 'departemen', 'source' => 'profile', 'field' => 'departemen'],
            ['label' => 'Status karyawan', 'editKey' => 'status_karyawan', 'source' => 'profile', 'field' => 'status_karyawan'],
            ['label' => 'Tanggal bergabung', 'editKey' => 'tanggal_bergabung', 'source' => 'profile', 'field' => 'tanggal_bergabung']
        ]
    ],
    [
        'title' => 'Atasan Langsung',
        'rows' => [
            ['label' => 'Nama supervisor / manager', 'editKey' => 'atasan_nama', 'source' => 'profile', 'field' => 'atasan_nama'],
            ['label' => 'Jabatan atasan', 'editKey' => 'atasan_jabatan', 'source' => 'profile', 'field' => 'atasan_jabatan']
        ]
    ],
    [
        'title' => 'Informasi Payroll',
        'rows' => [
            ['label' => 'Nomor rekening bank', 'editKey' => 'bank_rekening', 'source' => 'profile', 'field' => 'bank_rekening'],
            ['label' => 'Nama bank', 'editKey' => 'bank_nama', 'source' => 'profile', 'field' => 'bank_nama'],
            ['label' => 'Gaji pokok', 'editKey' => 'gaji_pokok', 'source' => 'gaji', 'fallback' => 'Tersembunyi']
        ]
    ],
    [
        'title' => 'Riwayat Pendidikan',
        'rows' => [
            ['label' => 'Pendidikan terakhir', 'editKey' => 'pendidikan_terakhir', 'source' => 'profile', 'field' => 'pendidikan_terakhir'],
            ['label' => 'Jurusan', 'editKey' => 'jurusan', 'source' => 'profile', 'field' => 'jurusan'],
            ['label' => 'Tahun lulus', 'editKey' => 'tahun_lulus', 'source' => 'profile', 'field' => 'tahun_lulus']
        ]
    ],
    [
        'title' => 'Riwayat Pekerjaan (Internal)',
        'rows' => [
            ['label' => 'Mutasi jabatan', 'editKey' => 'mutasi_jabatan', 'source' => 'profile', 'field' => 'mutasi_jabatan', 'fallback' => 'Belum ada'],
            ['label' => 'Promosi', 'editKey' => 'promosi', 'source' => 'profile', 'field' => 'promosi', 'fallback' => 'Belum ada'],
            ['label' => 'Perubahan status', 'editKey' => 'perubahan_status', 'source' => 'profile', 'field' => 'perubahan_status', 'fallback' => 'Belum ada']
        ]
    ],
    [
        'title' => 'Kontak Darurat',
        'rows' => [
            ['label' => 'Nama kontak darurat', 'editKey' => 'kontak_darurat_nama', 'source' => 'profile', 'field' => 'kontak_darurat_nama'],
            ['label' => 'Hubungan', 'editKey' => 'kontak_darurat_hubungan', 'source' => 'profile', 'field' => 'kontak_darurat_hubungan'],
            ['label' => 'Nomor yang bisa dihubungi', 'editKey' => 'kontak_darurat_nomor', 'source' => 'profile', 'field' => 'kontak_darurat_nomor']
        ]
    ]
];

$editConfig = [
    'nama' => [
        'title' => 'Edit Nama Lengkap',
        'inputs' => [
            ['name' => 'nama', 'label' => 'Nama lengkap', 'type' => 'text']
        ]
    ],
    'ttl' => [
        'title' => 'Edit Tempat & Tanggal Lahir',
        'inputs' => [
            ['name' => 'tempat_lahir', 'label' => 'Tempat lahir', 'type' => 'text'],
            ['name' => 'tanggallahir', 'label' => 'Tanggal lahir', 'type' => 'date']
        ]
    ],
    'jenis_kelamin' => [
        'title' => 'Edit Jenis Kelamin',
        'inputs' => [
            ['name' => 'jenis_kelamin', 'label' => 'Jenis kelamin', 'type' => 'text']
        ]
    ],
    'status_pernikahan' => [
        'title' => 'Edit Status Pernikahan',
        'inputs' => [
            ['name' => 'status_pernikahan', 'label' => 'Status pernikahan', 'type' => 'text']
        ]
    ],
    'kewarganegaraan' => [
        'title' => 'Edit Kewarganegaraan',
        'inputs' => [
            ['name' => 'kewarganegaraan', 'label' => 'Kewarganegaraan', 'type' => 'text']
        ]
    ],
    'foto' => [
        'title' => 'Edit Foto Profil',
        'inputs' => [
            ['name' => 'foto_profil', 'label' => 'Upload foto', 'type' => 'file', 'accept' => 'image/*']
        ]
    ],
    'nomor_hp' => [
        'title' => 'Edit Nomor HP',
        'inputs' => [
            ['name' => 'nomor_hp', 'label' => 'Nomor HP', 'type' => 'text']
        ]
    ],
    'email' => [
        'title' => 'Edit Email',
        'inputs' => [
            ['name' => 'email', 'label' => 'Email', 'type' => 'email']
        ]
    ],
    'alamat_domisili' => [
        'title' => 'Edit Alamat Domisili',
        'inputs' => [
            ['name' => 'alamat_domisili', 'label' => 'Alamat domisili', 'type' => 'textarea']
        ]
    ],
    'nik' => [
        'title' => 'Edit NIK',
        'inputs' => [
            ['name' => 'nik', 'label' => 'NIK (KTP)', 'type' => 'text']
        ]
    ],
    'npwp' => [
        'title' => 'Edit NPWP',
        'inputs' => [
            ['name' => 'npwp', 'label' => 'NPWP', 'type' => 'text']
        ]
    ],
    'bpjs' => [
        'title' => 'Edit BPJS',
        'inputs' => [
            ['name' => 'bpjs_kesehatan', 'label' => 'BPJS Kesehatan', 'type' => 'text'],
            ['name' => 'bpjs_ketenagakerjaan', 'label' => 'BPJS Ketenagakerjaan', 'type' => 'text']
        ]
    ],
    'nip' => [
        'title' => 'Edit NIP',
        'inputs' => [
            ['name' => 'nip', 'label' => 'NIP / Employee ID', 'type' => 'text']
        ]
    ],
    'jabatan' => [
        'title' => 'Edit Jabatan',
        'inputs' => [
            ['name' => 'jabatan', 'label' => 'Jabatan', 'type' => 'text']
        ]
    ],
    'departemen' => [
        'title' => 'Edit Departemen / Divisi',
        'inputs' => [
            ['name' => 'departemen', 'label' => 'Departemen / Divisi', 'type' => 'text']
        ]
    ],
    'status_karyawan' => [
        'title' => 'Edit Status Karyawan',
        'inputs' => [
            ['name' => 'status_karyawan', 'label' => 'Status karyawan', 'type' => 'text']
        ]
    ],
    'tanggal_bergabung' => [
        'title' => 'Edit Tanggal Bergabung',
        'inputs' => [
            ['name' => 'tanggal_bergabung', 'label' => 'Tanggal bergabung', 'type' => 'date']
        ]
    ],
    'atasan_nama' => [
        'title' => 'Edit Nama Atasan',
        'inputs' => [
            ['name' => 'atasan_nama', 'label' => 'Nama supervisor / manager', 'type' => 'text']
        ]
    ],
    'atasan_jabatan' => [
        'title' => 'Edit Jabatan Atasan',
        'inputs' => [
            ['name' => 'atasan_jabatan', 'label' => 'Jabatan atasan', 'type' => 'text']
        ]
    ],
    'bank_rekening' => [
        'title' => 'Edit Nomor Rekening',
        'inputs' => [
            ['name' => 'bank_rekening', 'label' => 'Nomor rekening bank', 'type' => 'text']
        ]
    ],
    'bank_nama' => [
        'title' => 'Edit Nama Bank',
        'inputs' => [
            ['name' => 'bank_nama', 'label' => 'Nama bank', 'type' => 'text']
        ]
    ],
    'gaji_pokok' => [
        'title' => 'Edit Gaji Pokok',
        'inputs' => [
            ['name' => 'gaji_pokok', 'label' => 'Gaji pokok', 'type' => 'number', 'step' => '0.01']
        ]
    ],
    'pendidikan_terakhir' => [
        'title' => 'Edit Pendidikan Terakhir',
        'inputs' => [
            ['name' => 'pendidikan_terakhir', 'label' => 'Pendidikan terakhir', 'type' => 'text']
        ]
    ],
    'jurusan' => [
        'title' => 'Edit Jurusan',
        'inputs' => [
            ['name' => 'jurusan', 'label' => 'Jurusan', 'type' => 'text']
        ]
    ],
    'tahun_lulus' => [
        'title' => 'Edit Tahun Lulus',
        'inputs' => [
            ['name' => 'tahun_lulus', 'label' => 'Tahun lulus', 'type' => 'text']
        ]
    ],
    'mutasi_jabatan' => [
        'title' => 'Edit Mutasi Jabatan',
        'inputs' => [
            ['name' => 'mutasi_jabatan', 'label' => 'Mutasi jabatan', 'type' => 'textarea']
        ]
    ],
    'promosi' => [
        'title' => 'Edit Promosi',
        'inputs' => [
            ['name' => 'promosi', 'label' => 'Promosi', 'type' => 'textarea']
        ]
    ],
    'perubahan_status' => [
        'title' => 'Edit Perubahan Status',
        'inputs' => [
            ['name' => 'perubahan_status', 'label' => 'Perubahan status', 'type' => 'textarea']
        ]
    ],
    'kontak_darurat_nama' => [
        'title' => 'Edit Kontak Darurat',
        'inputs' => [
            ['name' => 'kontak_darurat_nama', 'label' => 'Nama kontak darurat', 'type' => 'text']
        ]
    ],
    'kontak_darurat_hubungan' => [
        'title' => 'Edit Hubungan Kontak Darurat',
        'inputs' => [
            ['name' => 'kontak_darurat_hubungan', 'label' => 'Hubungan', 'type' => 'text']
        ]
    ],
    'kontak_darurat_nomor' => [
        'title' => 'Edit Nomor Kontak Darurat',
        'inputs' => [
            ['name' => 'kontak_darurat_nomor', 'label' => 'Nomor yang bisa dihubungi', 'type' => 'text']
        ]
    ]
];
