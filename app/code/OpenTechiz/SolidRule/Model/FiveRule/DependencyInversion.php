<?php


namespace OpenTechiz\SolidRule\Model\FiveRule;


class DependencyInversion
{
    //1. Các module cấp cao không nên phụ thuộc vào các modules cấp thấp. Cả 2 nên phụ thuộc vào abstraction.
    // 2. Abstraction không nên phụ thuộc vào chi tiết, mà ngược lại.

    public function getContent()
    {
        $content = 'ok di em';
        return $content;
    }

    // bây h ta có class $serializeClass chuyên xử lý convert
    // tuy nhiên điều này lại gây ra là class cấp cao  DependencyInversion này lại phải phụ thuộc vào class hỗ trợ $serializeClass
    // như vậy là đang vi phạm nguyên tắc D
    public function print1()
    {
        $content = $this->getContent();
        $serializeClass = '';
//        return $serializeClass->convert($content);
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
