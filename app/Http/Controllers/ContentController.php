<?php

namespace App\Http\Controllers;

use App\Category;
use App\Content;
use App\Http\Requests\ContentRequest;
use App\Http\Requests\ContentUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Affiche la liste des contenus.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $contents = Content::with('category')->paginate(20);
        return view('admin.contents.index', compact('contents'));
    }

    /**
     * Affiche le formulaire de création de contenu.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.contents.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau contenu en base de données.
     *
     * @param  ContentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContentRequest $request)
    {
        $arguments = $request->validated();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $originalFileName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images', $originalFileName, 'public');
            $arguments['image'] = '/storage/' . $imagePath;
        }
    
        Content::create($arguments);
    
        return redirect()->route('admin.contents.index')->with('success', 'Contenu ajouté avec succès.');
    }
    

    /**
     * Affiche le formulaire d'édition d'un contenu.
     *
     * @param  Content  $content
     * @return \Illuminate\View\View
     */
    public function edit(Content $content)
    {
        $categories = Category::all();
        return view('admin.contents.edit', compact('content', 'categories'));
    }

    /**
     * Met à jour un contenu existant.
     *
     * @param  ContentUpdateRequest  $request
     * @param  Content  $content
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContentUpdateRequest $request, Content $content)
    {
        $arguments = $request->validated();

        if ($request->hasFile('image')) {
            $oldImagePath = str_replace('/storage/', '', $content->image);
            if ($content->image && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            $image = $request->file('image');
            $originalFileName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('images', $originalFileName, 'public');
            $arguments['image'] = '/storage/' . $imagePath;
        }

        $content->update($arguments);

        return redirect()->route('admin.contents.index')->with('success', 'Contenu mis à jour avec succès.');
    }

    /**
     * Supprime un contenu et son image associée.
     *
     * @param  Content  $content
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Content $content)
    {
        $oldImagePath = str_replace('/storage/', '', $content->image);
        if ($content->image && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', 'Contenu supprimé avec succès.');
    }

    /**
     * Supprimer plusieurs contents sélectionnées.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
    
        if (!empty($ids)) {
            Content::whereIn('id', $ids)->delete();
            return redirect('/admin/contents')->with('success', 'Textes supprimés avec succès.');
        }
    
        return redirect('/admin/contents')->with('error', 'Aucun texte sélectionné.');
    }
}
