<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Paper;
use App\Models\Admin\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    /* @fun: 试题列表展示
     * @author: fanzhiyi
     * @date: 2017/7/7 11:26
     * @param:
     * @return:
     */
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.question.index');
        }

        if ($request->isMethod('post')) {
            $pagesize = $request->get('pageSize');
            $pagestart = $request->get('page') - 1;
            $offset = $pagestart * $pagesize;

            //拼接查询条件
            $query = Question::query();//查询对象
            //开始时间
            if ($start = $request->get('updated_start')) {
                $query->where('updated_at', '>', $start);
            }
            //终止时间
            if ($end = $request->get('updated_end')) {
                $query->where('updated_at', '<', $end);
            }
            if ($Protype_name = $request->get('brand_name')) {
                $query->where('question', 'LIKE', '%' . $Protype_name . '%');
            }
            $data = $query->leftjoin('paper','paper.id','=','question.paper_id')->select('question.*','paper.paper_name')->offset($offset)->limit($pagesize)->get()->toArray();
//    p($data);
            return [
                'draw' => $request->get('draw'),
                'recordsFiltered' => $query->count(),//被检索后的数量
                'recordsTotal' => $query->count(),//总记录数
                'data' => $data//返回的数据
            ];
        }
    }

    /* @fun:import | 导入试题
     * @author: fanzhiyi
     * @date: 2017/8/1 16:14
     * @param:
     * @return:
     */
    public function import(Request $request)
    {
        if($request->isMethod('get')){
            //取出试卷数据
            $paper =  Paper::get();

            return view('admin.question.import')->with(['paper'=>$paper]);
        } elseif($request->isMethod('post')){
            //数据验证
            $this->validate($request, [
                'paper_id' => 'required',
                'filepath' => 'required',
            ]);
            $paper_id = $request->get('paper_id');
            $filePath = 'public'.$request->get('filepath');

            Excel::load($filePath, function($reader) use($paper_id){
                $data = $reader->getSheet(0)->toArray();
                foreach($data as $k=>$v){
                    if($k=='0'){
                        continue;
                    }
                    $result = Question::insert([
                        'question' => $v['0'],
                        'paper_id' => $paper_id,
                        'score' => $v['3'],
                        'options'=> $v['1'],
                        'answer'=> $v['2'],
                        'created_at'=>date('Y-m-d H:i:s')
                    ]);

                    if(!$result){
                        return [
                            'status' => 2,
                            'msg' => 'failed!',
                        ];
                    }
                }
                //返回成功信息
                echo json_encode([
                    'status' => 1,
                    'msg' => 'success!',
                ]);
            });
        }
    }

    /* @fun:export | 导出试题
     * @author: fanzhiyi
     * @date: 2017/8/1 16:14
     * @param:
     * @return:
     */
    public function export(Request $request)
    {
        if($request->isMethod('get')){
            //取出试卷数据
            $paper =  Paper::get();
            return view('admin.question.export')->with(['paper'=>$paper]);
        } elseif($request->isMethod('post')){
            //接收参数
            $paper_id = $request->get('paper_id');//试卷id
            $paper_name =Paper::where('id',$paper_id)->first()->paper_name;//试卷名称

            if(!$paper_id){
                return back()->withErrors('请选择试卷!');
            }else{
                //组装要导出的数据
                $data = Question::where('paper_id',$paper_id)->select('question','options','answer','score')->get()->toarray();

                //$paper_name,Sheetname是单个excel的名字,也就是文档打开后下面的sheet
                Excel::create($paper_name, function($excel) use($data){

                    $excel->sheet('Sheetname', function($sheet) use($data) {

                        $sheet->fromArray($data);

                    });

                })->download('xls');
            }
        }
    }

    /* @fun: 添加试题
     * @author: fanzhiyi
     * @date: 2017/7/7 15:04
     * @param:
     * @return:
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //取出试卷数据
            $paper =  Paper::get();

            return view('admin/question/add')->with(['paper'=>$paper]);
        }

        if ($request->isMethod('post')) {
            //数据验证
            $this->validate($request, [
                'question' => 'required|unique:question,question|max:255',
                'paper_id' => 'required',
                'score' => 'required',
                'options' => 'required',
                'answer' => 'required',
            ]);

            //接受入库的数据
            $data = $request->except('_token');

            //删除空数据
            $data = delRepeat($data);

            //插入数据
            $res = Question::create($data);

            if ($res) {
                return [
                    'status' => 1,
                    'msg' => 'add success!'
                ];
            } else {
                return [
                    'status' => 2,
                    'msg' => 'add failed!'
                ];
            }

        }

    }

    /* @fun: 批量删除试题
     * @author: fanzhiyi
     * @date: 2017/7/9 21:50
     * @param: $ids 要删除数据的id
     * @return:
     */
    public function del(Request $request)
    {
        $id = $request->get('id');

        //结果保存
        $res = '';

        //非空判断
        if (!$id) {
            $res = false;
        }else{
            //批量删除
            if (is_array($id)) {
                $res = Question::whereIn('id', $id)->delete();//返回受影响的行数
            } else {
                $res = Question::where('id', $id)->delete();
            }
        }

        //返回结果
        if ($res) {
            return [
                'status' => 1,
                'msg' => 'del success!'
            ];
        } else {
            return [
                'status' => 2,
                'msg' => 'del failed!'
            ];
        }
    }


    /* @fun: 修改试题的显示页面
     * @author: fanzhiyi
     * @date: 2017/7/10 11:37
     * @param: $id 要修改的试题id
     * @return:
     */
    public function edit($id, Request $request)
    {
        if ($request->isMethod('get')) {
            //获取要修改的这条数据
            $edit = DB::table('question')->where('id', $id)->first();;

            //获取试卷数据
            $paper = DB::table('paper')->select('id','paper_name')->get();

            //返回数据并显示页面
            return view('admin.question.edit')->with(['edit'=>$edit,'paper'=>$paper]);
        }

        if ($request->isMethod('post')) {
            //获取准备更新的数据
            $input = $request->only(['question', 'paper_id', 'score', 'options','answer','remark']);

            //删除空数据
            $data = delRepeat($input);

            //执行更新操
            $res = Question::where('id', '=', $id)->update($input);

            //返回执行结果
            if ($res) {
                return [
                    'status' => 1,
                    'msg' => 'edit success!'
                ];
            } else {
                return [
                    'status' => 2,
                    'msg' => 'edit failed!'
                ];
            }
        }
    }
}
