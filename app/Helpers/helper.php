<?php

function formatTanggal($date)
{
    if (!$date) {
        return '-';
    }

    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $timestamp = strtotime($date);
    $tgl = date('j', $timestamp);
    $bln = date('n', $timestamp);
    $thn = date('Y', $timestamp);

    return $tgl . ' ' . $bulan[$bln] . ' ' . $thn;
}

function formatRupiah($data)
{
    return 'Rp ' . number_format($data, 0, ',', '.');
}

function formatAngka($data)
{
    return number_format($data, 0, ',', '.');
}

function formatPercentase($data)
{
    return number_format($data, 0, ',', '.') . ' %';
}
