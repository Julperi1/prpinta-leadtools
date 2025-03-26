import subprocess
import shutil
import os
import zipfile

def build_and_copy():
    # Run the npm build command in the specified project directory.
    try:
        subprocess.check_call(["npm", "run", "build"])
        print(f"npm build completed successfully.")
    except subprocess.CalledProcessError as e:
        print(f"Error during npm build {e}")
        return

    # Define the source and destination directories.
    source_dir = os.path.join("dist", "assets")
    dest_dir = os.path.join("build")

    if not os.path.exists(source_dir):
        print(f"Source directory {source_dir} does not exist.")
        return

    # Ensure the destination directory exists.
    os.makedirs(dest_dir, exist_ok=True)

    # Copy each file and folder from the source to the destination.
    for item in os.listdir(source_dir):
        src_path = os.path.join(source_dir, item)
        dest_path = os.path.join(dest_dir, item)

        if os.path.isdir(src_path):
            shutil.copytree(src_path, dest_path, dirs_exist_ok=True)
        else:
            shutil.copy2(src_path, dest_path)

    print(f"Files copied successfully from {source_dir} to {dest_dir}")




def copy_plugin():
    # Define source and destination for plugin.php.
    src = "plugin.php"
    dst = os.path.join("build", "plugin.php")
    
    if not os.path.exists(src):
        print(f"Source file {src} does not exist.")
        return
    
    # Ensure the build directory exists.
    os.makedirs("build", exist_ok=True)
    
    # Copy plugin.php to the build folder.
    shutil.copy2(src, dst)
    print(f"{src} copied successfully to {dst}")




def zip_build_contents(build_dir="./build", zip_name="leadtools.zip"):
    # Full path to the zip file (placed inside build_dir)
    zip_path = os.path.join(build_dir, zip_name)
    
    # Create a new zip file in write mode
    with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
        # Walk through all files and subdirectories in build_dir
        for root, dirs, files in os.walk(build_dir):
            for file in files:
                file_path = os.path.join(root, file)
                # Skip the zip file itself if it exists in the build folder
                if os.path.abspath(file_path) == os.path.abspath(zip_path):
                    continue
                # Compute the archive name relative to build_dir
                arcname = os.path.relpath(file_path, build_dir)
                zipf.write(file_path, arcname)
                
    print(f"Created zip archive: {zip_path}")




if __name__ == "__main__":
    if os.path.exists("build"):
        shutil.rmtree("build")
        print("Deleted existing build directory.")

    # Build and copy assets for both projects.
    build_and_copy()
    
    # Finally, copy plugin.php to ./build.
    copy_plugin()

    # Zip the contents of the build directory.
    zip_build_contents()
