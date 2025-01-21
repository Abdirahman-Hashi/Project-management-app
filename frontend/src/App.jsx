import React, { useState, useEffect } from 'react';
import ProjectForm from './components/ProjectForm';
import ProjectList from './components/ProjectList';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import './App.css';

function App() {
  const [projects, setProjects] = useState([]);
  const [editingProject, setEditingProject] = useState(null);

  useEffect(() => {
    fetchProjects();
  }, []);

  const fetchProjects = async () => {
    try {
      const response = await fetch('http://localhost:8000/api/projects');
      if (!response.ok) throw new Error('Failed to fetch projects');
      const data = await response.json();
      setProjects(data);
    } catch (error) {
      toast.error('Error fetching projects: ' + error.message);
    }
  };

  const handleProjectSubmit = async (projectData) => {
    try {
      const url = editingProject
        ? `http://localhost:8000/api/projects/${editingProject.id}`
        : 'http://localhost:8000/api/projects';
      
      const method = editingProject ? 'PUT' : 'POST';
      
      const response = await fetch(url, {
        method,
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(projectData),
      });

      if (!response.ok) throw new Error('Failed to save project');
      
      await fetchProjects();
      toast.success(`Project ${editingProject ? 'updated' : 'created'} successfully!`);
      setEditingProject(null);
    } catch (error) {
      toast.error('Error saving project: ' + error.message);
    }
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Are you sure you want to delete this project?')) return;
    
    try {
      const response = await fetch(`http://localhost:8000/api/projects/${id}`, {
        method: 'DELETE',
      });

      if (!response.ok) throw new Error('Failed to delete project');
      
      await fetchProjects();
      toast.success('Project deleted successfully!');
    } catch (error) {
      toast.error('Error deleting project: ' + error.message);
    }
  };

  const handleEdit = (project) => {
    setEditingProject(project);
  };

  return (
    <div className="container-custom py-8">
      <h1 className="text-3xl font-bold mb-8 text-center">Project Management System</h1>
      
      <ProjectForm 
        onSubmit={handleProjectSubmit}
        editingProject={editingProject}
        onCancel={() => setEditingProject(null)}
      />
      
      <ProjectList 
        projects={projects}
        onEdit={handleEdit}
        onDelete={handleDelete}
      />
      
      <ToastContainer position="bottom-right" />
    </div>
  );
}

export default App;
