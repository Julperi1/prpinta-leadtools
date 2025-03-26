import subprocess
import shutil
import os

def build_and_copy(project):
    # Run the npm build command in the specified project directory.
    try:
        subprocess.check_call(["npm", "run", "build"], cwd=project)
        print(f"npm build for {project} completed successfully.")
    except subprocess.CalledProcessError as e:
        print(f"Error during npm build for {project}: {e}")
        return

    # Define the source and destination directories.
    source_dir = os.path.join(project, "dist", "assets")
    dest_dir = os.path.join("build", project)

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

if __name__ == "__main__":
    # Build and copy assets for both projects.
    build_and_copy("sitebot")
    build_and_copy("paintcalc")
    
    # Finally, copy plugin.php to ./build.
    copy_plugin()
