# How to Add Movie Posters

The system is now configured to use JPG poster images from your local storage directory.

## Where to Place Poster Images

All poster images should be placed in:
```
storage/app/public/posters/
```

## Required Poster Files

Add JPG files with these exact filenames:

1. `harry-potter-philosophers-stone.jpg`
2. `the-dark-knight.jpg`
3. `inception.jpg`
4. `the-shawshank-redemption.jpg`
5. `pulp-fiction.jpg`
6. `lord-of-the-rings-fellowship.jpg`
7. `forrest-gump.jpg`
8. `the-matrix.jpg`
9. `titanic.jpg`
10. `the-avengers.jpg`
11. `toy-story.jpg`
12. `the-conjuring.jpg`

## Image Specifications

- **Format**: JPG/JPEG
- **Recommended Size**: 272 x 400 pixels (standard movie poster aspect ratio)
- **Quality**: 80-90 for web use

## How to Access the Directory

If using a file manager, navigate to:
```
C:\xampp\htdocs\Cinema-Project\Cinema-Project-PDC03-main\storage\app\public\posters\
```

## After Adding Posters

1. Place your JPG files in the `storage/app/public/posters/` directory
2. Refresh your browser (Ctrl+Shift+R for hard refresh)
3. The posters should now display on the movie cards

The system will automatically serve them via the public storage symlink at `/public/storage/posters/`.
