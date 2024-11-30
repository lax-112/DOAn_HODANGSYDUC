<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class CarController extends Controller
{
    // Hiển thị danh sách xe
    public function index()
    {
        $cars = Car::all(); // Lấy tất cả xe
        return view('admin.cars.index', compact('cars'));
    }

    // Hiển thị form để tạo xe mới
    public function create()
    {
        return view('admin.cars.create');
    }

    // Lưu xe mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'seats' => 'required|integer',
            'price_per_day' => 'required|numeric',
            'is_available' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $car = new Car();
        $car->name = $request->name;
        $car->brand = $request->brand;
        $car->license_plate = $request->license_plate;
        $car->type = $request->type;
        $car->seats = $request->seats;
        $car->price_per_day = $request->price_per_day;
        $car->is_available = $request->is_available;

        // Lưu hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $car->image = $imagePath; // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
        }

        $car->save();

        return redirect()->route('cars.index')->with('success', 'Xe đã được thêm thành công!');
    }

    // Hiển thị form để sửa xe
    public function edit(int $id)
    {
        $car = Car::findOrFail($id); // Tìm xe theo ID
        return view('admin.cars.edit', compact('car'));
    }

    // Cập nhật xe
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:cars,license_plate,' . $id,
            'type' => 'required|string|max:255',
            'seats' => 'required|integer',
            'price_per_day' => 'required|numeric',
            'is_available' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $car = Car::findOrFail($id);
        $car->name = $request->name;
        $car->brand = $request->brand;
        $car->license_plate = $request->license_plate;
        $car->type = $request->type;
        $car->seats = $request->seats;
        $car->price_per_day = $request->price_per_day;
        $car->is_available = $request->is_available;

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
        
            // Tạo tên tệp hình ảnh duy nhất
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        
            // Lưu ảnh mới vào thư mục 'cars'
            $imagePath = $request->file('image')->storeAs('cars', $imageName, 'public');
            $car->image = $imagePath;
        }
        
        

        $car->save();

        return redirect()->route('cars.index')
                         ->with('success', 'Cập nhật xe thành công.');
    }

    // Xóa xe
    public function destroy(int $id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('cars.index')
                         ->with('success', 'Xe đã được xóa thành công.');
    }

    /**
     * Show the order page for the car.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function order(int $id)
    {
        $car = DB::table('cars')->find($id);

        // Kiểm tra xem xe có tồn tại hay không
        if (!$car) {
            return redirect()->route('index')->with('error', 'Xe không tồn tại.');
        }

        return view('car_order', compact('car'));
    }

    public function confirmOrder(Request $request, int $id)
    {
        //dd($id);
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'user_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        // Tìm xe theo ID
        $car = DB::table('cars')->find($id);
        //dd($car );

        // Tạo mới một order
        $order = new CarOrder(); // Đảm bảo sử dụng đúng tên lớp CarOrder
        $order->car_id = $car->id; // Gán car_id từ model Car
        $order->user_name = $validatedData['user_name'];
        $order->phone = $validatedData['phone'];
        $order->email = $validatedData['email'];
        $order->start_date = $validatedData['start_date'];
        $order->end_date = $validatedData['end_date'];

        // Lưu thêm thông tin từ xe
        $order->car_name = $car->name;
        $order->car_brand = $car->brand;
        $order->license_plate = $car->license_plate;
        $order->type = $car->type;
        $order->seats = $car->seats;
        $order->price_per_day = $car->price_per_day;

        $order->save(); // Lưu thông tin vào CSDL

        $cars = DB::table('cars')->get();

        // Trả về view car.blade.php với biến success và cars
        return view('car', [
            'success' => 'Đặt xe thành công!',
            'car' => $car,
            'cars' => $cars // Truyền biến $cars vào view
        ]);
    }
    public function rentedCars()
    {
        // Lấy danh sách các đơn hàng xe đã đặt từ bảng car_orders
        $rentedCars = CarOrder::all(); // Giả định rằng bạn có một mối quan hệ 'car' trong mô hình CarOrder

        return view('admin.cars.rented_cars', compact('rentedCars'));
    }
}
