import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { HashRouter, Routes, Route } from "react-router-dom";
import Index from "./pages/Index";
import NotFound from "./pages/NotFound";
import UnderConstruction from "./pages/UnderConstruction";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <HashRouter>
        <Routes>
          <Route path="/" element={<Index />} />
          <Route path="/profile" element={<UnderConstruction />} />
          <Route path="/friends" element={<UnderConstruction />} />
          <Route path="/rewards" element={<UnderConstruction />} />
          <Route path="/chat" element={<UnderConstruction />} />
          <Route path="/stats" element={<UnderConstruction />} />
          <Route path="/leaderboard" element={<UnderConstruction />} />
          <Route path="/categories/:category" element={<UnderConstruction />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </HashRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
