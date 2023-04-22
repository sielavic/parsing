<?php
$url =  $_SERVER['DOCUMENT_ROOT']."/assets/Фото_сотрудников_за_период_с_11_01_2023_по_11_01_2023_20230111093630.html";

        $dom = new DOMDocument();
        $dom->loadHTMLFile($url);
        $child_elements = $dom->getElementsByTagName('tr');
        foreach ($child_elements as $key=>$child_element) {
            $biosmart[$key]['id'] = trim($child_element->nodeValue);
        }

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key=>$image) {
            $img = str_replace('data:image/png;base64,', '', $image->getAttribute('src'));
            $img = str_replace(' ', '+', $img);
            $img_decode = base64_decode($img);
            $dir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/biosmart_avatars/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $dir_min = $_SERVER['DOCUMENT_ROOT'].'/assets/images/biosmart_avatars/avatar_miniatur/';
            if (!file_exists($dir_min)) {
                mkdir($dir_min, 0777, true);
            }


file_put_contents($dir  .$biosmart[$key]['id'] . '.png', $img_decode);

            $config['image_library'] = 'gd2'; // выбираем библиотеку
            $config['source_image'] = $dir.$biosmart[$key]['id'] . '.png';
            $config['create_thumb'] = FALSE; // ставим флаг создания эскиза
            $config['maintain_ratio'] = TRUE; // сохранять пропорции
            $config['width'] = 150; // и задаем размеры
            $config['height'] = 150;
            $config['new_image'] = $dir_min.$biosmart[$key]['id'] . '.png';

            $this->load->library('image_lib', $config); // загружаем библиотеку
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
