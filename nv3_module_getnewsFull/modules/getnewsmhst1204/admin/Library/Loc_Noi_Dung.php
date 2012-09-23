<?php

/**
 * @author CUONG
 * @copyright 2012
 */
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simple_html_dom.php");
//include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simplepie.inc");
//class GetRSS
//{
//    static function GetLink($link)
//    {
//        $arr=array();
//        $feed = new SimplePie();
//        $feed->set_feed_url($link);
//        $feed->enable_cache(false);
//        $feed->init();
//        $feed->handle_content_type();
//        $count=$feed->get_item_quantity();
//        foreach($feed->get_items() as $item)
//        {
//            $arr[]=$item->get_permalink();
//        }
//        return $arr;
//    }
//}
class GetContent
{
    static function main($link)
    {
        $html=file_get_html($link);
        $root=$html->find("body",0);
        $a=$root;
        $pos=array();
        $chose=array();
        $b=$root;
        $Title=array();
        $head=array();
        $conten=array();
        
        
        while(count($a->childNodes())>0)
        {
            $nub=GetContent::FindArea($a,$chose);
            $pos[]=$nub;
            $a=$a->children($nub);
        }
        
        $asdf=GetContent::FindAreaConfig($chose,$pos);
        
        foreach($pos as $p)
        {
            $b=$b->children($p);
        }
        
        $tag=array("h1","h2","p");
        
        
        $XpathFull=GetContent::SplitAuto($b,$tag,$Title,$head,$conten,$pos,$root,$link);
        return $XpathFull;
    }
    
    
    
    
    
    //Hàm này có tác dụng tự động tìm kiếm đoạn text theo từng nội dung như tiêu đề, mô tả và nội dung bài viết.
    static function SplitAuto($b,$tag,&$Title,&$head,&$conten,$pos,$root,$link)
    {
        //Tìm xpath tới tiêu đề
        $Title1="";$des1="";$xet1="";$t=0;$t1=1;
        $tempTitle=$pos;
        $Title=GetContent::FindTitle($tag,$b,$tempTitle);
        //Tìm Xpath tới mô tả:
        $nodeHead=GetContent::ReturnNode($root,$Title);
        $Title1=GetContent::ChangeXpath($nodeHead,$Title1);
        $Title1[]=$nodeHead->tag;
        $TitlePath=GetContent::ArrayToString($Title1,$t1);
        $tieude=$nodeHead->plaintext;
        $head=$Title;
        $head=GetContent::FindHead($nodeHead->parent(),10,$Title[count($Title)-1],$head);
        //Tim Xpath t?i n?i dung:
        $nodeContent=GetContent::ReturnNode($root,$head);
        $des1=GetContent::ChangeXpath($nodeContent,$des1);
        $des1[]=$nodeContent->tag;
        $headPath=GetContent::ArrayToString($des1,$t1);
        $mota=$nodeContent->plaintext;
        $conten=$head;
        $conten=GetContent::FindHead($nodeContent->parent(),3,$head[count($head)-1],$conten);
        //kiem tra xem neu node do ma la em thi se lay node cha cua no cho tong quat
        $xet=GetContent::ReturnNode($root,$conten);
        if(is_null($xet) || $xet->tag=="em"){array_pop($conten);}
        $xet1=GetContent::ChangeXpath($xet,$xet1);
        $contentPath=GetContent::ArrayToString($xet1,$t);
        $maxword=GetContent::CountTotalWord($mota);
        $noidung=GetContent::CheckNode($root,$conten,$maxword);
        $noidung=InsertNews::replaceLinkImg($noidung,$link);
        $XpathFull=array('tieude'=>$tieude,'mota'=>$mota,'noidung'=>$noidung,'titlepath'=>$TitlePath,'headpath'=>$headPath,'contentpath'=>$contentPath);
        return $XpathFull;
    }
    
    
    
    
    static function ArrayToString($arr,$check)
    {
        $kq="";
        for($i=0;$i<count($arr);$i++)
        {
            if($check==1)
            {
                if($i==(count($arr)-1))$kq.="-".$arr[$i].",";
                else $kq.=$arr[$i].",";
            }
            else $kq.=$arr[$i].",";
        }
        //$kq=substr($kq,0,strlen($kq)-2);
        return $kq;
    }
    //Ham nay co tac dung tim ra node cha chua id hoac class.
    static function ChangeXpath($node,$titlePath)
    {
        $parent=$node->parent();
        if($parent->getAttribute("id")==null&& $parent->getAttribute("class")==null)
        {
            $titlePath=GetContent::ChangeXpath($parent,$titlePath);
        }
        $att=$parent->getAttribute("id")!=null?(("id=").$parent->getAttribute("id")):("class=".$parent->getAttribute("class"));
        $count=0;
        if($node->previousSibling())
        {
            $sibling=$node->previousSibling();
            do{
                $count=$count+1;
                $sibling=$sibling->previousSibling();
            }while($sibling);
        }
        if($att!=null && $att!="class=")
        {
            $titlePath[]=$att;
            $titlePath[]=$count;
        } 
        else
        {
            $titlePath[]=$count;
        }
        return $titlePath;
    }
    
    //Ham lay noi dung cua phan content
    static function CheckNode($root,&$content,$wordmax)
    {
        //bien vt de luu vi tri cua node con chon cuoi,bien temp de luu vi tri cua node con dau.
        $vt=$content[count($content)-1];
        $node=GetContent::ReturnNode($root,$content);
        $kq="";
        if(!is_null($node))
        {
            $word=GetContent::CountTotalWord($node->plaintext);
            //Lấy tỷ lệ số từ trong node đang xét với số từ của phần mô tả, nếu nhỏ hơn 3 thì xét node cha của node hiện tại đang xét
            //Giá trị 3 ở đây có ý nghĩa là phần nội dung phải có số từ lớn gấp 3 lần số từ trong phần mô tả, có thể tùy chỉnh giá trị này nhỏ xuống hoặc tăng lên.
           
            $per=$word/$wordmax;
            while($per<3)
            {
                $kq="";
                $kq.=$node->plaintext;
                //Trong khi van con node anh em thi van tiep tuc lay
                while(!is_null($node->nextSibling()))
                {
                    $node=$node->nextSibling();
                    //Neu node dang xet ma chua nhieu the a thi co the no la node chua nhung tin lien quan, nen to se bo node do di
                    $dem=$node->find("a");if(count($dem)>3) break;
                    //Neu node dang xet la script thi ta dung luon vong lap.
                    if($node->tag=="script") break;
                    $kq.=$node->outertext();
                    $vt=$vt+1;
                }
                $word=GetContent::CountTotalWord($kq);//Dem so tu trong toan bo node vua dem dc
                $per=$word/$wordmax;
                //Neu ti le nho hon 3 thi lay node cha de xet tiep, hay noi cach khac la loai phan tu cuoi cung trong mang content.
                if($per<3)
                {
                    array_pop($content);
                    $node=GetContent::ReturnNode($root,$content);
                }
            }
        }
        return $kq;
    }
    
    
    //Hàm tìm mô tả
    static function FindHead($node,$count,&$i,&$head)
    {
        $check=false;//Biến này để lưu kết quả, khi mà tìm thấy vị trí thích hợp có số lượng từ lớn hơn giới hạn thì trả về giá trị true;
        $checkSib=false;//Hàm này để xác định xem node đó có node em cùng cấp hay không.
        $totalChild=count($node->childNodes());//Đếm số con của node truyền vào.
        if($i==$totalChild-1)//Khi mà node đang xét không có node em nào
        {
            array_pop($head);//Loại một phần tử cuối ra khỏi mảng head tương ứng với vị trí node đang xét, để xét tới node cha nó.
            $head=GetContent::FindHead($node->parent(),3,$head[count($head)-1],$head);//Gọi lại hàm tìm mô tả.
        }
        else
        {
            $node=$node->children($i);//Chuyển tới thằng con ở phần tiêu đề đã tìm thấy trong DOM
            if(!is_null($node))
            {
                    while(!is_null($node->nextSibling())&& $i<$totalChild)//Nếu có node con và vị trí node con đang xét nhỏ hơn tổng số node con
                {
                    $checkSib=true;//Gán biến này thành true để xác định là nó đang xét node cùng cấp
                    //Nếu khi xét biến cùng cấp mà không tìm ra thì sẽ xét node ông của node hiện tại.
                    //Nếu khi xét biến không cùng cấp thì sẽ xét tiếp node cha của node hiện tại.
                    $nextnode=$node->nextSibling();//Chuyển tới node em
                    if(GetContent::CountTotalWord($nextnode->plaintext)>$count)//Đếm số từ của node đó.
                    {
                        $i=$i+1;array_pop($head);//Loại bỏ vị trí cuối cùng đang có trong mảng head.
                        $head[]=$i;//Lưu vị trí của đã tìm được vào mảng head.
                        //Khi mà vị trí tìm được vẫn còn node con thì gọi tới hàm A để tìm tới node con thỏa mãn dk hơn.
                        //if($nextnode->tag!="table")
//                        {
                            $head=GetContent::A($nextnode,$head,$check);
                        //}
                        $check=true;//Gán hàm check bằng true và kết thúc vòng lặp.
                        break;
                    }
                    else
                    {
                        //Nếu số từ của node nhỏ hơn điều kiện
                        //Thì gán node=node em và quay lại vòng lặp xét tiếp.
                        $node=$nextnode;
                        $i++;
                    }
                }
                //Khi kết thúc vòng lặp mà vẫn không tìm thấy vị trí
                if(!$check)
                {
                    //Nếu không xét node cùng cấp
                    if(!$checkSib)
                    {
                        $i=$head[count($head)-1];//Lấy vị trí của node cha node đang xet trong DOM
                        $node=$node->parent();//Gán node hiện tại bằng node cha
                        $head=GetContent::FindHead($node,$count,$i,$head);//GỌi lại hàm
                    }
                    else
                    {
                        $i=$head[count($head)-1];//Lấy vị trí của node cha node đang xét trong DOM
                        array_pop($head);//Loại bỏ một phần tử cuối ra khỏi mảng head.
                        $node=$node->parent()->parent();//Xét node ông của node hiện tại.
                        $head=GetContent::FindHead($node,$count,$i,$head);//GỌi lại hàm.
                    }
                }
            }
        }
        return $head;
    }
    
    //Hàm này được dùng để xét tiếp node đã thỏa mãn điều kiện, tìm tới node con thỏa mãn dk hơn.
    static function A($node,&$head,&$check)
    {
        $i=0;
        $child=$node->childNodes();
        if(count($child)>0)
        {
            foreach($child as $chil)
            {
                
                if($chil->tag=="a" || $chil->tag=="br")//Không xét những node có thẻ tag là a và br.
                {
                    //$chil->innertext="";
                    continue;
                }
                if(GetContent::CountTotalWord($chil->plaintext)>10)
                {
                    if(count($chil->childNodes())>0)//Nếu node đó có con
                    {
                        $head[]=$i;//Thêm vị trí vào mảng head.
                        $head=GetContent::A($chil,$head,$check);//GỌi lại hàm  để xét tiếp.
                    }
                    else
                    {
                        $check=true;//Nếu hết con thì biến check bằng true để kết thúc vòng lặp.
                        $head[]=$i;//Thêm vị trí vào mảng head.
                        break;
                    }
                }
                if(!$check)
                {
                    $i++;
                }
                else break;
            }    
        }
        return $head;
    }
    
    
    //Hàm này được dùng để chuyển mảng xpath thành truy vần tới node cụ thể,
    static function ReturnNode($b,$pos)
    {
        foreach($pos as $p)
        {
            if(!is_null($b->children($p)))
            {
                $b=$b->children($p);
            }
            
        }
        return $b;
    }
    
    //Hàm này dùng để tìm tiêu đề.
    static function FindTitle($tag,$b,$tempTitle)
    {
        //Duyệt mảng các thẻ tag.Nếu tìm thấy node nào trùng với giá trị của mảng thì kết thục luôn.
        foreach($tag as $t)
        {
            $check=false;
            $tempTitle=GetContent::FindXpath($b->childNodes(),$t,$tempTitle,$check);
            if(count($tempTitle)>0)
            {
                break;
            }
        }
        return $tempTitle;
    }
    
    //Hàm này được dùng để tìm ra xpath lưu vào csdl từ một node.
    static function FindXpath($b,$tagName,&$xpath,&$check)
    {
        $i=0;
        foreach($b as $child)
        {
            $xpath[]=$i;//Thêm vị trí vào mảng kết quả
            //Nếu tên tag trùng với giá trị mảng thì kết thúc hàm.
            if($child->tag==$tagName)
            {
                $check=true;
                return $xpath;
            }
            else
            {
                if(!$check)
                {
                    //Nếu mà node còn con thì gọi lại hàm để xét tiếp.
                    if(count($child->childNodes())>0)
                    {
                        GetContent::FindXpath($child->childNodes(),$tagName,$xpath,$check);
                    }
                    //Nếu không sẽ loại bỏ giá trị cuối cùng ra khỏi mảng.
                    else
                    {
                        array_pop($xpath);
                    }
                }
                //Khi biến điều kiện mà sai
                else
                {
                    //Loại bỏ giá trị cuối cùng ra khỏi mảng.
                    array_pop($xpath);
                    break;
                } 
            }
            $i++;
        }
        //Khi kết thúc vòng lặp mà không tìm thấy sẽ loại bỏ giá trị cuối cùng ra khỏi magnr.
        if(!$check)
        {
            array_pop($xpath);
        }
        
        return $xpath;
    }
    
    
    //Hàm này để bước đầu tìm ra khu vực cần lấy.
    static function FindArea($node,&$chose)
    {
        $children=$node->childNodes();
        $count=0;$kq=0;$total=array();$i=0;
        foreach($children as $child)//Duyệt các node con
        {
            //echo $child->tag;
            $count=GetContent::CountTotalWord($child->plaintext);//Đếm số từ lấy được trong node con đó.
            if($count>30)
            {
                array_push($total,$count."@".$i);//Nếu số lượng từ lớn hơn 30, thì cho vào mảng.Mục đích của mảng này là để lưu giữ những node có số từ lớn hơn 30
                //Sau đó tìm ra node có số lượng từ lớn nhất.
            }
            $i++;
        }
        $kq=GetContent::FindMax($total,$chose);
        return $kq;
    }
    
    //Tìm ra vị trí lớn nhất trong mảng
    static function FindMax($arr,&$chose)
    {
        $max=0;$kq=0;
        for($i=0;$i<count($arr);$i++)
        {
            $temp=split("@",$arr[$i]);
            if($max<$temp[0])
            {
                $max=$temp[0];
                $kq=$temp[1];
            }
        }
        $chose[]=$max;
        return $kq;
    }
    
    //Hàm này nhằm chuẩn hóa hơn khu vực cần lấy
    static function FindAreaConfig($chose,&$pos)
    {
        $max=1.3;$vitri=0;
        //Sau khi có được số lượng từ lớn nhất từ các node tổng hợp được ở trên, hệ thống sẽ tìm ra khoảng cách nào có số nhảy cao nhất
        //Khi gặp khoảng cách lớn hơn so với bình thường, lập tức chọn khoảng đó.
        for($i=0;$i<count($chose)-1;$i++)
        {
            if($chose[$i+1]!=0)
            {
                $temp=($chose[$i]/$chose[$i+1]);//Lấy phần nguyên của cái trước chia cho cái sau, nếu nó có bước nhày lớn hơn 1 thì chọn và kết thúc vòng lặp luôn.
                if($max<=$temp)
                {
                    $max=$temp;
                    $vitri=$i;
                    break;
                }
            }
        }
        //Sau khi tìm được vị trí có bước nhảy lớn nhất, loại bỏ khỏi mảng vị trí những giá trị thừa
        //số lượng thừa ở đây chính là bằng số phần tử trong mảng vị trí trừ đi vị trí có bước nhảy lớn đầu tiên.
        $j=count($pos)-$vitri;
        for($z=0;$z<$j-1;$z++)
        {
            array_pop($pos);
        }
        return $pos;
    }
    
    //Đếm ố từ có trong một chuỗi.
    static function CountTotalWord($string)
    {
        $string=ltrim($string);
        $temp=array();
        $temp=split(" ",$string);
        //print_r($temp);
        return count($temp);
    }
}

class InsertNews
{
    static function GetValue($link,$titleLink,$descripLink,$contentLink)
    {
        $arr=array();
        $html=file_get_html($link);
        $body=$html->find('body',0);
        
        $kt=true;
        $vtxet=0;
        $title=InsertNews::ReturnNode($titleLink,$body,$kt,$vtxet);
        $arr['tieude']=$title->plaintext;
        if($descripLink!="" && $contentLink!="")
        {
            $head=InsertNews::ReturnNode($descripLink,$body,$kt,$vtxet);
            $arr['mota']=$head->plaintext;
            $vt1=0;$xpath="";$vt=0;
            $arrSplit=split("@",$contentLink);
            if(count($arrSplit)>1)
            {
               $vt1=substr($arrSplit[1],0,count($arrSplit[1])-2);
               $xpath=$arrSplit[0];
               $vt=substr($xpath,strlen($xpath)-2,1);
            }
            else 
            {
                $xpath=$contentLink;
                $vt=substr($xpath,strlen($xpath)-2,1);
            }
            $xet=$vtxet;
            $con=InsertNews::ReturnNode($xpath,$body,!$kt,$vtxet);
            $source=InsertNews::GetContent($con,$vt,$vt1,$xet);
            $source=InsertNews::replaceLinkImg($source,$link);
            $arr['noidung']=$source;
        }
        $html->clear();
        return $arr;
    }
    
    function replaceLinkImg($source,$link)
    {
        $temp=parse_url($link);
        $host=$temp['host'];$host=str_replace("www.","",$host);
        $linkImg="";
        $arrImg=InsertNews::GetImage($source);
        if(count($arrImg)>0)
        {
            for($j=0;$j<count($arrImg);$j++)
            {
                if(!nv_is_url($arrImg[$j]))
                {
                    $linkImg="http://www.".$host.str_replace(" ","%20",$arrImg[$j]);
                }
                else $linkImg=str_replace(" ","%20",$arrImg[$j]);
                $source=str_replace($arrImg[$j],$linkImg,$source);
            }
        }
        return $source;
    }
    
    static function GetContent($node,$vt,$vt1,$vttrc)
    {
        $parent=$node->parent();
        $child=$parent->childNodes();
        //Dem so con cua node cha node truyen vao
        $count=count($child);
        //Dem so node la comment
        $com=count($parent->find('comment'));
        //neu so node comment lon hon 0 thi ko tinh no vao so node con cua node cha truyen vao
        if($com>0) $count=$count-$com;
        $kq="";
        //Bien vttrc de luu vi tri cua node mota, phong truong hop khi config, khong co nhung node an
        //Nhung khi chon phai tin co chua node an dang truoc.
        if($vt<=$vttrc)$vt=$vttrc+1;
        while($vt<($count-$vt1))
        {
            if($parent->children($vt)->tag!="script" || $parent->children($vt)->tag!="comment")
            {
                $kq.=$parent->children($vt)->outertext();
            }
            $vt++;
        }
        return $kq;
    }
    
    static function ReturnNode($xpath,$node,$kt,&$vtxet)
    {
        $vttrc=0;
        $child=split(',',$xpath);
        $chi=$node->find("[".$child[0]."]",0);
        $check=substr($child[count($child)-1],1);
        for($i=1;$i<count($child)-1;$i++)
        {
            if($child[$i]!="" && $child[$i]!="class=null" && $child[$i]!="class=")
            {
                $count=count($chi->children());
                if($child[$i]<$count)
                {
                    $chi=$chi->children($child[$i]);
                }
            }
        }
        
        if($kt)
        {
            $tag=strtolower($check);
            if(strtolower($chi->tag)!=$tag)
            {
                $chi=$chi->parent()->find($tag,0);
            }
        }
        $pre=$chi->previousSibling();
        while($pre)
        {
            $vtxet=$vtxet+1;
            $pre=$pre->previousSibling();
        }
        return $chi;
    }
    static function get_regex($regex)
	{
		$regex=str_replace("/","\/",$regex);
		return "/".$regex."/";
	}
        
    static function GetImage($content)	
	{
		$regex='src="(?<linkimage>.*?)"';
		$regex=InsertNews::get_regex($regex);
		$content=preg_replace('/\s+/'," ",$content);
		preg_match_all($regex,$content,$result);
		return $result['linkimage'];
	}
    static  function GetHref($content)	//Lay link anh
	{
		$regex='href="(?<link>.*?)"';
		$regex=InsertNews::get_regex($regex);
		$content=preg_replace('/\s+/'," ",$content);
		preg_match_all($regex,$content,$result);
		return $result['link'];
	}
}

class GetContentArtice
{
    //Tim tin tieu diem chinh:
    static function FindDiffMain($link,$title)
    {
        $html=file_get_html($link);$titlePath=array();
        $a=$html->find('a');$chi=0;$arr=array();
        foreach($a as $tag)
        {
            $sub=strpos(change_alias($tag->plaintext),trim($title));
            if($sub!==false)
            {
                $titlePath=GetContentArtice::ChangeXpath($tag->parent(),$titlePath);break;
            }
        }
        return GetContentArtice::ArrayToString($titlePath);
    }
    //tim tin khac
    function FindDiff($link,$title,$des)
    {
        $titleClass="";$desClass="";$path="";$titlePath=array();$desPath=array();$content="";
        $html=file_get_html($link);
        $a=$html->find('a');$chi=0;$arr=array();
        foreach($a as $b)
        {
            $sub=strpos(change_alias($b->plaintext),trim($title));
            if($sub!==false)
            {
                $titlePath=GetContentArtice::ChangeXpath($b,$titlePath);$check=false;$chi=0;
                if(count($b->parent()->children())>2)
                {
                    $nex=$b->nextSibling();
                    $count=count($b->parent()->children());$j=0;
                    do{
                        $sub2=strpos($nex->plaintext,trim($des));
                        if($sub2!==false)
                        {
                            $chi=count($b->parent()->children());
                            $desPath=GetContentArtice::ChangeXpath($nex,$desPath);$check=true;
                            break;
                        }
                        $j++;
                        if($j<$count-1)
                        { 
                            $nex=$nex->nextSibling();
                        }
                    }while($nex && $j<$count-1);
                    if(!$check)
                    {
                        $parent1=$b->parent();$i=0;
                        $nextSib=$parent1->nextSibling();
                        $countchild=count($parent1->parent()->children());$i=0;
                        do{
                            $sub1=strpos(str_replace("\"","",$nextSib->plaintext),trim($des));
                            if($sub1!==false)
                            {
                                $chi=count($parent1->parent()->children());
                                $desPath=GetContentArtice::ChangeXpath($nextSib,$desPath);
                                break;
                            }
                            $i++;
                            if($i<$countchild-1)
                            {
                               $nextSib=$nextSib->nextSibling(); 
                            }
                        }while($nextSib && $i<($countchild-1));
                    }
                }
                else
                {
                    $parent1=$b->parent();$i=0;
                    $nextSib=$parent1->nextSibling();
                    $countchild=count($parent1->parent()->children());$i=0;
                    do{
                        $sub1=strpos($nextSib->plaintext,trim($des));
                        if($sub1!==false)
                        {
                            $chi=count($parent1->parent()->children());
                            $desPath=GetContentArtice::ChangeXpath($nextSib,$desPath);
                            break;
                        }
                        $i++;
                        if($i<$countchild-1)
                        {
                           $nextSib=$nextSib->nextSibling(); 
                        }
                    }while($nextSib && $i<($countchild-1));
                }
                $path=$desPath[0];
                if($titlePath[0]!=$desPath[0])
                {
                    array_unshift($titlePath,$path);
                    break;
                }
                else break;
            }
        }
        if(!is_null($path) && $titlePath!="" && $desPath!="")
        {
            $arr[]=$path;
            $tieude=GetContentArtice::ArrayToString($titlePath);
            $arr[]=$tieude;
            $mota=GetContentArtice::ArrayToString($desPath);
            $arr[]=$mota;
        }
        else $arr=null;
        return $arr;
    }
    
    static function ArrayToString($arr)
    {
        $kq="";
        foreach($arr as $a)
        {
            $kq.=$a.",";
        }
        return $kq;
    }
    
    static function CountTotalWord($string)
    {
        $string=trim($string);
        $temp=array();
        $temp=split(" ",$string);
        return count($temp);
    }
    
    static function ReturnNode($mang,$node)
    {
        $arr=split(",",$mang);
        $chi=$node;
        for($i=1;$i<count($arr);$i++)
        {
            if(strpos($arr[$i],"class=")!==false)
            {
                $chi=$chi->find("[".$arr[$i]."]",0);
            }
            else if(strpos($arr[$i],"id=")!==false)
            {
                $chi=$chi->find("[".$arr[$i]."]",0);
            }
            else
            {
                $chi=$chi->children($arr[$i]);
            }
        }
        return $chi;
    }
    
    static function ChangeXpath($node,$titlePath)
    {
        $parent=$node->parent();
        if($parent->getAttribute("id")==null&& $parent->getAttribute("class")==null)
        {
            $titlePath=GetContentArtice::ChangeXpath($parent,$titlePath);
        }
        $att=$parent->getAttribute("id")!=null?(("id=").$parent->getAttribute("id")):("class=".$parent->getAttribute("class"));
        $count=0;
        if($node->previousSibling())
        {
            $sibling=$node->previousSibling();
            do{
                $count=$count+1;
                $sibling=$sibling->previousSibling();
            }while($sibling);
        }
        if($att!=null && $att!="class=")
        {
            $titlePath[]=$att;
            $titlePath[]=$count;
        } 
        else
        {
            $titlePath[]=$count;
        }
        return $titlePath;
    }
}

class GetArticle
{
    static function GetValueMain($link,$path)
    {
        $arr=array();
        $sp=split(",",$path);
        $html=file_get_html($link);
        $temp=parse_url($link);
        $host=$temp['host'];$host=str_replace("www.","",$host);
        $node=$html->find("[".$sp[0]."]");
        foreach($node as $no)
        {
            $tin=GetArticle::ReturnNode($path,$no);
            if($tin)
            {
                $count=count($tin->parent()->children());
                for($z=0;$z<$count;$z++)
                {
                    if($tin->parent()->children($z)->tag==$tin->tag)
                    {
                        $link1="";
                        $arrLink=InsertNews::GetHref($tin->parent()->children($z)->outertext());
                        foreach($arrLink as $a)
                        {
                            if(!nv_is_url($a))
                            {
                                $link1="http://www.".$host."/".$a;
                            }
                            else $link1=$a;
                        }
                        
                        $arr[]=array("tieude"=>$tin->parent()->children($z)->plaintext,"mota"=>$tin->parent()->children($z)->plaintext,"link"=>$link1);
                    }
                }
            }
            
        }
        return $arr;
    }
    
    //Lay nhung tin tuc khac
    static function GetValue($link,$path,$title,$des)
    {
        $arr=array();
        $html=file_get_html($link);
        $temp=parse_url($link);
        $host=$temp['host'];$host=str_replace("www.","",$host);
        $par=$html->find("[".$path."]");
        foreach($par as $k)
        {
            $total=GetContentArtice::CountTotalWord($k->plaintext);
            $ul=$k->find("ul");
            if($total>10 && count($ul)==0)
            {
                $tt=GetArticle::ReturnNode($title,$k);
                if($tt)
                {
                    $link1="";
                    $arrLink=InsertNews::GetHref($tt->outertext());
                    foreach($arrLink as $a)
                    {
                        if(!nv_is_url($a))
                        {
                            $link1="http://www.".$host."/".$a;
                        }
                        else $link1=$a;
                    }
                    
                    $arr[]=array("tieude"=>$tt->plaintext,"mota"=>GetArticle::ReturnNode($des,$k)->plaintext,"link"=>$link1);
                }
            }
        }
        return $arr;
    }
    
    //static function CheckLink($link)
//    {
//        $check=false;
//        global $db;
//        $result=$db->sql_query("select * from nv_new_temp where link='".$link."'");
//        $nub=$db->sql_numrows($result);
//        if($nub>0) $check=true;
//        return $check;
//    }
    
    static function ReturnNode($mang,$node)
    {
        $chi=$node;
        $arr=split(",",$mang);
        for($i=1;$i<count($arr);$i++)
        {
            if($arr[$i]!="")
            {
                if(strpos($arr[$i],"class=")!==false)
                {
                    $chi=$chi->find("[".$arr[$i]."]",0);
                }
                else if(strpos($arr[$i],"id=")!==false)
                {
                    $chi=$chi->find("[".$arr[$i]."]",0);
                }
                else
                {
                    $chi=$chi->children($arr[$i]);
                }
            }
        }
        return $chi;
    }
}
?>