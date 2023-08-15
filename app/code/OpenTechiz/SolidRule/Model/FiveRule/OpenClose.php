<?php


namespace OpenTechiz\SolidRule\Model\FiveRule;


class OpenClose
{
    //Có thể thoải mái mở rộng 1 class nhưng không được sửa đổi bên trong class đó (open for extension but closed for modification)
    // tlức à khi viết 1 method thì nên tính để luôn khả năng method đó sẽ sử dụng cho nhiều trường hợp, và khi mở rộng class thì ta ko cần phải sửa đổi lại
    // code của class

    public function getContent()
    {
        $content = 'ok di em';
        return $content;
    }

    // nếu ta viết method print ntn thì khi 1 class khác kế thừa class này
    // nhưng muốn đổi định dạng kết quả của method print là json chứ ko phải serialize thì ta lại phải override lại method print này
    public function print1()
    {
        $content = $this->getContent();
        return serialize($content);
    }

    // khi viết method ntn thì sẽ có cover đc nhiều case khác nhau hơn mà ko cần phải sửa code nhiều ở class kế thừa class này
    // với cách viết ntn thì ta
    public function print2($type = 'serialize')
    {
        $content = $this->getContent();
        switch ($type) {
            case 'json':
                return json_encode($content);
                break;
            case 'string':
                return $content->toString();
                break;
            default:
                return serialize($content);
        }

    }
}
