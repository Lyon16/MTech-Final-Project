<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::orderByDesc('id')->paginate(10);

        return view('products.index', compact('products'));
    }

    // Show Add Product form
    public function create()
    {
        return view('products.create');
    }

    // Save new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'image' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg', 'png'])
                    ->max('2mb'),
            ],
        ]);

        $validated['created_at'] = now();

        // Prepare a display-ready image if uploaded
        if ($request->hasFile('image')) {
            $validated['image'] = $this->prepareProductImage(
                $request->file('image')
            );
        }

        try {
            Product::create($validated);
        } catch (\Throwable $e) {
            // Remove uploaded image if database insertion fails
            if (!empty($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }

            throw $e;
        }

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    // View product details
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Show Edit Product form
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update product information
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'image' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg', 'png'])
                    ->max('2mb'),
            ],
        ]);

        $oldImage = $product->image;
        $newImage = null;

        // Prepare replacement image if uploaded
        if ($request->hasFile('image')) {
            $newImage = $this->prepareProductImage(
                $request->file('image')
            );

            $validated['image'] = $newImage;
        }

        try {
            $product->update($validated);
        } catch (\Throwable $e) {
            // Remove replacement image if update fails
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }

        // Remove previous image after successful update
        if ($newImage && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete product if it has no sales history
    public function destroy(Product $product)
    {
        $image = DB::transaction(function () use ($product) {
            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($product->id);

            if ($product->sales()->exists()) {
                return false;
            }

            $image = $product->image;

            $product->delete();

            return $image ?? '';
        });

        if ($image === false) {
            return redirect()->route('products.index')
                ->with(
                    'error',
                    'Products with sales history cannot be deleted.'
                );
        }

        // Remove product image after successful deletion
        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    // Prepare a 600 x 600 display-ready product image
    private function prepareProductImage($file): string
    {
        $manager = new ImageManager(new Driver());

        // Read uploaded JPG or PNG
        $image = $manager->read($file->getRealPath());

        // Resize proportionally without enlarging small images
        $image->scaleDown(width: 600, height: 600);

        // Create white square background
        $canvas = $manager->create(600, 600);
        $canvas->fill('#ffffff');

        // Calculate centered position
        $x = (int) floor((600 - $image->width()) / 2);
        $y = (int) floor((600 - $image->height()) / 2);

        // Place resized image in center
        $canvas->place($image, 'top-left', $x, $y);

        // Generate unique JPG filename
        $path = 'products/' . Str::uuid() . '.jpg';

        // Save optimized JPG in public storage
        Storage::disk('public')->put(
            $path,
            (string) $canvas->toJpeg(quality: 85)
        );

        return $path;
    }
}
