<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
 
class ComicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' => $this->id,
            'description' => $this->description,
            'page_count' => $this->page_count,
            'thumbnail_url' => $this->thumbnail_url,
            'series_name' => $this->series_name,
            'created_at' => $this->created_at,
            'title' => $this->title,
            'updated_at' => $this->updated_at,
        ];
    }
}