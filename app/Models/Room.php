<?php

namespace App\Models;

use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $path = 'public/images/rooms/';

    /**
     * Get the tour that owns the room.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Validate rules for room
     *
     * @param int|null $id
     * @return array
     */
    public function rules(int $id = null): array
    {
        return [
            'hotel_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'number' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Save room data (create or update).
     *
     * @param Request $request
     * @param int $tourId
     * @param int $id
     * @return int
     */
    public function saveData(Request $request, int $tourId, int $id = 0): int
    {
        // Clear XSS from input name
        //$name = Utilities::clearXSS($request->name);
        // Find room by ID or create a new instance
        $room = $this->findOrNew($id);

        // Prepare input data for saving
        $input = [
            'tour_id' => $id ? $room->tour_id : $tourId,
            'hotel_name' => $request->hotel_name,
            'name' => $request->name,
            'price' => $request->price,
            'number' => $request->number,
            'description' => $request->description,
            'status' => $request->status,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $input['image'] = Utilities::storeImage($request->file('image'), $this->path);
        } else {
            // Keep existing image if no new image is uploaded
            $input['image'] = $room->image ?? null; 
        }

        // Save room data to the database
        $room->fill($input);
        $room->save();

        return 1;
    }

    /**
     * Delete the room by id in database.
     *
     * @param int $id
     * @return bool
     */
    public function remove(int $id): bool
    {
        $room = $this->findOrFail($id);
        return $room->delete();
    }

    /**
     * Get a list of room
     *
     * @param int $tourId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getList(int $tourId)
    {
        $data = $this->where('tour_id', $tourId)->oldest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->setRowId(fn($data) => 'Room-' . $data->id)
            ->editColumn('image', function ($data) {
                $pathImage = asset("storage/images/rooms/" . $data->image);
                return view('components.image', compact('pathImage'));
            })
            ->editColumn('price', fn($data) => number_format($data->price) . 'đ')
            ->editColumn('status', function ($data) {
                $link = route('rooms.update', ['tour_id' => $data->tour_id, 'id' => $data->id]);
                $class = 'btn-switch-status';
                $statusText = $data->status ? 'Active' : 'Inactive'; // Chỉnh sửa hiển thị status
                return view('components.button_switch', [
                    'status' => $data->status, 
                    'link' => $link, 
                    'class' => $class,
                    'status_text' => $statusText // Truyền text status để hiển thị
                ]);
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("rooms.update", ['tour_id' => $data->tour_id, 'id' => $data->id]);
                $linkDelete = route("rooms.destroy", ['tour_id' => $data->tour_id, 'id' => $data->id]);
                return view('components.action_modal', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->addColumn('detail', function ($data) {
                $imageRoom = route('galleries_room.index', $data->id);
                $width = 69;

                $view = view('components.action',
                    ['link' => $imageRoom, 'title' => 'ảnh phòng', 'width' => $width])->render();

                return $view;
            })
            ->rawColumns(['action', 'image','detail', 'status'])
            ->make(true);
    }

}
