<?php

namespace App\Http\Controllers\Admin;
use DataTables;
use App\Models\Blog;
use App\Helpers\Helper;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App;



class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->language = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($this->language->name);
    }

    //*** JSON Request
    public function datatables()
    {
          //--- Returning Json Data To Client Side
    $datas = Blog::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
                            
                            ->editColumn('category_id', function(Blog $data) {
                                return $data->category->name;
                            })
                            ->addColumn('action', function(Blog $data) {
                                return '<div class="action-list"><a href="'. route('admin-blog-edit',$data->id) . '"  class="btn btn-primary btn-sm mr-2"> <i class="fas fa-edit mr-1"></i>'. __('Edit') .'</a><a href="javascript:;" data-href="' . route('admin-blog-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></div>';
                            })

                            ->addColumn('image', function(Blog $data) {
                                $image = $data->image->image != null? url('assets/images/blogs/'.$data->image->image):url('assets/images/noimage.png');
                                return '<img src="' . $image . '" alt="Image" width="100"> ';
                            })

                            ->editColumn('serial', function(Blog $data) {
                                $check = '<input type="checkbox" class="bulk-check" value="'.$data->id.'">';
                                return $check;
                             })

                            ->rawColumns(['status','action','image','serial'])
                            ->toJson();

    //*** GET Request

     }
    //*** GET Request
    public function index()
    {
        return view('admin.blog.index');
    }

    //*** GET Request
    public function create()
    {
        $cats = BlogCategory::where('status',1)->get();
        return view('admin.blog.create',compact('cats'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'photo'      => 'required|mimes:jpeg,jpg,png,svg',
               'title' => 'required|unique:blogs',
               'category_id' => 'required',
               'description' => 'required|min:15',
                ];
               
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        
        //--- Logic Section
        $data = new Blog();
        $input = $request->all();
      
        if (!empty($request->meta_tag)) 
         {
            $input['meta_tag'] = Helper::TagFormat($request->meta_tag) ;  
         }  
        if (!empty($request->tags)) 
         {
            $input['tags'] =  Helper::TagFormat($request->tags); 
         }

         $input['slug'] = Helper::slug($request->title);
      

        $id = $data->create($input)->id;
        //--- Logic Section Ends

         $model = Blog::findOrFail($id);

         if($request->hasFile('photo')){
             $file = $request->photo;
             $location = base_path('../assets/images/blogs/');
             Helper::MakeImage($file,$location,$model);
         }else{
            Helper::NullImage($model);
         }

        //--- Redirect Section        
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    //*** GET Request
    public function edit($id)
    {
        $cats = BlogCategory::where('status',1)->get();
        $data = Blog::findOrFail($id);
        return view('admin.blog.edit',compact('data','cats'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

       
        //--- Validation Section
        $rules = [
                'photo'      => 'mimes:jpeg,jpg,png,svg',
                'title' => 'required|unique:blogs,title,'.$id,
                'category_id' => 'required',
                'description' => 'required|min:15',
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Blog::findOrFail($id);
        $input = $request->all();
          //--- Logic Section
          $input['slug'] = Helper::slug($request->title);
      
        if (!empty($request->meta_tag)) 
         {
            $input['meta_tag'] = Helper::TagFormat($request->meta_tag) ;  
         }  
        if (!empty($request->tags)) 
         {
            $input['tags'] =  Helper::TagFormat($request->tags); 
         }

        $data->update($input);
        //--- Logic Section Ends

        if($request->hasFile('photo')){
            $image = $request->photo;
            $location = base_path('../assets/images/blogs/');
            Helper::ImageUpdate($image,$location,$data);
        }
        //--- Redirect Section     
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends            
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Blog::findOrFail($id);
        //If Photo Doesn't Exist
        if($data->image->image == null){
            $data->delete();
            //--- Redirect Section     
            $msg = __('Data Deleted Successfully.');
            return response()->json($msg);      
            //--- Redirect Section Ends     
        }
        //If Photo Exist
        if (file_exists(base_path('../assets/images/blogs/'.$data->image->image))) {
            unlink(base_path('../assets/images/blogs/'.$data->image->image));
        }
        $data->delete();
        //--- Redirect Section     
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
}
